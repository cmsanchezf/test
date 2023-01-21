<?php

namespace Drupal\snaper_web_services\Plugin\rest\resource;

use Drupal\Core\Cache\Cache;
use Psr\Log\LoggerInterface;
use Drupal\rest\ResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Resource to retrieve all marvel cards.
 *
 * @RestResource(
 *   id = "variants_all",
 *   label = @Translation("All Variants"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/variant/{cid}"
 *   }
 * )
 */
class Variants extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new ExampleResource object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $accountProxy
   *   A current user instance.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   A cache instance.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   A entity type manager instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    private AccountProxyInterface $accountProxy,
    private CacheBackendInterface $cache,
    private EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('current_user'),
      $container->get('cache.default'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Responds to GET requests.
   *
   * Return variants for a given card.
   *
   * @param string $cid
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   */
  //throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
  public function get(string $cid) {
    // Ensure that the user has permission to access this resource.
    if (!$this->accountProxy->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
    $result = [];
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheTags(['variants_' . $cid]);
    if ($cache = $this->cache->get('variants_' . $cid)) {
      $result = $cache->data;
      $cache_metadata->setCacheMaxAge(Cache::PERMANENT);
    }
    $query = $this->entityTypeManager->getStorage('marvel_card')->getQuery();
    $query->condition('cid', $cid);
    $marvel_card_id = $query->execute();
    /** @var \Drupal\marvel_card\Entity\MarvelCard[] $marvel_card */
    $marvel_card = $this->entityTypeManager->getStorage('marvel_card')->loadMultiple($marvel_card_id);
    $query = $this->entityTypeManager->getStorage('variant')->getQuery();
    $query->condition('cid', $cid);
    $variant_ids = $query->execute();
    /** @var \Drupal\variant\Entity\Variant[] $variants */
    $variants = $this->entityTypeManager->getStorage('variant')->loadMultiple($variant_ids);
    $name = str_replace(' ', '%20', reset($marvel_card)->get('name')->value);
    foreach ($variants as $variant) {
      $result[] = [
        'cid' => (int) $cid,
        'vid' => (int) $variant->get('vid')->value,
        'art' => "https://snaper.ddev.site/sites/default/files/img/variants/" . $name . "_" . $variant->get('variant_order')->value . "webp",
        'art_filename' => $name . "_" . $variant->get('variant_order')->value . "webp",
        'rarity' => $variant->get('rarity')->value,
        'rarity_slug' => $variant->get('rarity_slug')->value,
        'variant_order' => $variant->get('variant_order')->value,
        'status' => $variant->get('status')->value,
        'full_description' => $variant->get('full_description')->value,
      ];
    }

    $this->cache->set('variants_' . $cid, $result, time() + 86400, ['variants_' . $cid]);

    return new ResourceResponse($result);
  }

}
