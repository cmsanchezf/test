<?php

namespace Drupal\drupal_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Drupal API routes.
 */
class DrupalApiController extends ControllerBase {



  /**
   * The controller constructor.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $plugin_manager_block
   *   The plugin.manager.block service.
   */
  public function __construct(private PluginManagerInterface $plugin_manager_block, private ConfigFactoryInterface $config_factory) {
    $this->pluginManagerBlock = $plugin_manager_block;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.block'),
      $container->get('config.factory')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    // Rendering the slider_block Block.
    $block_plugin = $this->pluginManagerBlock->createInstance('drupal_api_top_issues_block', []);
    $block_build = $block_plugin->build();
    $block_content = render($block_build);

    return [
      '#theme' => 'top_issues_page',
      '#block' => $block_content,
    ];
  }

}
