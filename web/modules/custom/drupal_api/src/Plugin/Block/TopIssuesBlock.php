<?php

namespace Drupal\drupal_api\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\drupal_api\Services\DrupalAPIClient;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class provide a block to show top Issues of project mantained at drupal.org.
 *
 * Data for this block comes from drupal_api_config.settings.
 *
 * @Block(
 *   id="drupal_api_top_issues_block",
 *   admin_label = @Translation("Top Issues"),
 *   category = @Translation("borjatest")
 * )
 */
class TopIssuesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructor for TopIssuesBlock.
   *
   * @param array $configuration
   *   The configuration.
   * @param string $plugin_id
   *   The id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin definition parameters.
   * @param \Drupal\Core\Session\AccountProxyInterface $accountProxy
   *   The Account Proxy service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The Entity Type Manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   * @param \Drupal\drupal_api\Services\DrupalAPIClient $drupalApiClient
   *   The Drupal API Client (custom)
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, private AccountProxyInterface $accountProxy, private EntityTypeManagerInterface $entityTypeManager, private ConfigFactoryInterface $configFactory, private DrupalAPIClient $drupalApiClient) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('config.factory'),
      $container->get('drupal_api.drupal_api_calls'),
    );
  }

  /**
   * Build function .
   *
   * @return array
   *   renderable array
   */
  public function build() {
    $config = $this->configFactory->get('drupal_api_config.settings');
    $response = $this->drupalApiClient->getTopIssues();
    $response = $response->getBody()->getContents();


    foreach (json_decode($response)->list as $key => $value) {
      $list[] = (array) $value;
    }

    array_multisort(array_map(function ($element) {
      return $element['comment_count'];
    }, $list), SORT_DESC, $list);

    return [
      '#theme' => 'top_issues_block',
      '#project_name' => $config->get('drupal_api.project_name'),
      '#items' => $config->get('drupal_api.items'),
      '#data' => array_slice($list, 0, $config->get('drupal_api.items')),
    ];
  }

    /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $tags =  ['borja_tag'];
    return Cache::mergeTags($tags, parent::getCacheTags());
  }

}
