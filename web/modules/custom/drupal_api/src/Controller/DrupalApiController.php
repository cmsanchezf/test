<?php

namespace Drupal\drupal_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Plugin\PluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\RendererInterface;

/**
 * Returns responses for Drupal API routes.
 */
class DrupalApiController extends ControllerBase {

  /**
   * The controller constructor.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $plugin_manager_block
   *   The plugin.manager.block service.
   * @param Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config.factory service.
   */
  public function __construct(private PluginManagerInterface $plugin_manager_block, private RendererInterface $renderer) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.block'),
      $container->get('renderer'),
    );
  }

  /**
   * Builds the response.
   *
   * @return array
   *   A simple renderable array.
   */
  public function build() {
    // Rendering the slider_block Block.
    $block_plugin = $this->plugin_manager_block->createInstance('drupal_api_top_issues_block', []);
    $block_build = $block_plugin->build();
    $block_content = $this->renderer->render($block_build);

    return [
      '#theme' => 'top_issues_page',
      '#block' => $block_content,
    ];
  }

}
