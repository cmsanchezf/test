<?php

namespace Drupal\drupal_api\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 *   id="drupal_api_top_issues_block",
 *   admin_label = @Translation("Top Issues"),
 *   category = @Translation("borjatest")
 * )
 */
class TopIssuesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  private CacheBackendInterface $cache;

  /**
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, private AccountProxyInterface $accountProxy, private EntityTypeManagerInterface $entityTypeManager, private ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->cache = \Drupal::cache();
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   *
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('config.factory'),
    );
  }

  /**
   *
   */
  public function build() {
    $config = $this->configFactory->get('drupal_api_config.settings');
    $cache = $this->cache->get('drupal_api_project_data_' . $config->get('drupal_api.project_nid'));

    if ($cache) {
      dump($cache);
      return [
        '#theme' => 'top_issues_block',
        '#project_name' => $config->get('drupal_api.project_name'),
        '#items' => $config->get('drupal_api.items'),
        '#data' => array_slice($cache->data, 0, $config->get('drupal_api.items')),
      ];
    }
    $client = \Drupal::httpClient();
    $request = $client->request('GET', 'https://www.drupal.org/api-d7/node.json?type=project_issue&field_issue_status=1&field_project=' . $config->get('drupal_api.project_nid'));
    $response = $request->getBody()->getContents();

    foreach (json_decode($response)->list as $key => $value) {
      $list[] = (array) $value;
    }

    array_multisort(array_map(function ($element) {
      return $element['comment_count'];
    }, $list), SORT_DESC, $list);

    $this->cache->set('drupal_api_project_data_' . $config->get('drupal_api.project_nid'), $list, Cache::PERMANENT,
    ['drupal_api:project', 'project:' . $config->get('drupal_api.project_nid')]
    );

    return [
      '#theme' => 'top_issues_block',
      '#project_name' => $config->get('drupal_api.project_name'),
      '#items' => $config->get('drupal_api.items'),
      '#data' => array_slice($list, 0, $config->get('drupal_api.items')),
    ];
  }

}
