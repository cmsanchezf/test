<?php

namespace Drupal\drupal_api\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\drupal_api\Services\DrupalAPIClient;
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
   * @param \Drupal\drupal_api\Services\DrupalAPIClient $drupalApiClient
   *   The Drupal API Client (custom)
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, private DrupalAPIClient $drupalApiClient) {
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
      $container->get('drupal_api.drupal_api_calls'),
    );
  }

  /**
   * Build function .
   *
   * @return array
   *   renderable array
   */
  public function build(): array {
    // Retrieve from block config.
    $config = $this->getConfiguration();
    $project = $config['project_nid'];
    $name = $config['project_name'];
    $items = $config['items'];

    $request = $this->drupalApiClient->getTopIssues($project);
    $list = [];
    foreach (json_decode($request)->list as $value) {
      $list[] = (array) $value;
    }

    $commentCounts = array_map(function ($element) {
      return $element['comment_count'];
    }, $list);

    array_multisort($commentCounts, SORT_DESC, $list);

    return [
      '#theme' => 'top_issues_block',
      '#project_name' => $name,
      '#items' => $items,
      '#data' => array_slice($list, 0, $items),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    // Get the saved values for the project name and number of items.
    // Use default values if the keys do not exist in the configuration array.
    $project_name = $config['project_name'] ?: '';
    $items = $config['items'] ?? 5;

    $form['project_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Project name'),
      '#default_value' => $project_name,
      '#required' => TRUE,
    ];

    $form['items'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of items'),
      '#default_value' => $items,
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 10,
    ];

    return $form;
  }

  /**
   * Implements hook_block_submit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Set the configuration values for the block based on the user's input.
    $this->setConfigurationValue('project_machine_name', $form_state->getValue('project_machine_name'));
    $this->setConfigurationValue('items', (string) $form_state->getValue('items'));
  }

  /**
   * Implements hook_block_validate().
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $response = $this->drupalApiClient->getModuleData($values['project_name']);

    if (!$response) {
      $form_state->setError($form, $this->t('You should provide the machine name of a current mantained project at drupal.org'));
    }
    else {
      $this->setConfigurationValue('project_nid', $response[0]->nid);
      $this->setConfigurationValue('project_name', $response[0]->title);

    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $tags = ['borja_tag'];
    return Cache::mergeTags($tags, parent::getCacheTags());
  }

}
