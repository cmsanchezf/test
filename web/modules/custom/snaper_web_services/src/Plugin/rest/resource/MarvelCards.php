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
use Drupal\Core\File\FileUrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Resource to retrieve all marvel cards.
 *
 * @RestResource(
 *   id = "marvel_cards_all",
 *   label = @Translation("All Marvel Cards"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/marvel_cards/all"
 *   }
 * )
 */
class MarvelCards extends ResourceBase {

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
    private EntityTypeManagerInterface $entityTypeManager,
    private FileUrlGeneratorInterface $urlGenerator) {
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
      $container->get('file_url_generator')
    );
  }

  /**
   * Function to set permissions.
   */
  public function permissions() {
    return [];
  }

  /**
   * Responds to GET requests.
   *
   * Returns a simple "Hello World" message.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   */
  public function get() {
    // Ensure that the user has permission to access this resource.
    if (!$this->accountProxy->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    /** @var array $result */
    $result = [];
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheTags(['marvel_cards_all']);
    if ($cache = $this->cache->get('marvel_cards_all')) {
      $result = $cache->data;
      $cache_metadata->setCacheMaxAge(Cache::PERMANENT);
    }
    /** @var \Drupal\marvel_card\Entity\MarvelCard[] $marvel_cards */
    $marvel_cards = $this->entityTypeManager->getStorage('marvel_card')->loadMultiple();
    foreach ($marvel_cards as $marvel_card) {
      /** @var \Drupal\media\Entity\Media */
      $media = $marvel_card->get('art')->entity;
      /** @var \Drupal\file\Entity\File $file */
      $file = $media->get('field_media_image')->entity;
      $url = $this->urlGenerator->generateAbsoluteString($file->getFileUri());
      $result[] = [
        'cid' => (int) $marvel_card->get('cid')->value,
        'name' => $marvel_card->get('name')->value,
        'type' => $marvel_card->get('type')->value,
        'cost' => (int) $marvel_card->get('cost')->value,
        'power' => (int) $marvel_card->get('power')->value,
        'ability' => $marvel_card->get('ability')->value,
        'flavor' => $marvel_card->get('flavor')->value,
        'art' => $url,
        'alternate_art' => $marvel_card->get('alternate_art')->value,
        'url' => $marvel_card->get('url')->value,
        'status' => $marvel_card->get('status')->value,
        'carddefid' => $marvel_card->get('carddefid')->value,
        'variants' => $this->getVariants($marvel_card->get('cid')->value),
      ];
    }
    $this->cache->set('marvel_cards_all', $result, time() + 86400, ['marvel_cards_all']);
    // Create encoder with specified options as new default settings.
    return new ResourceResponse($result);
  }

  /**
   * Helper function to get the variants of the marvel card.
   *
   * @param string $cid
   *   The cid of the marvel card.
   *
   * @return array
   *   Array with the variants.
   */
  private function getVariants($cid): array {
    $result = [];
    $query = $this->entityTypeManager->getStorage('variant')->getQuery();
    $query->condition('cid', $cid);
    $variant_ids = $query->execute();
    /** @var \Drupal\variant\Entity\Variant[] $variants */
    $variants = $this->entityTypeManager->getStorage('variant')->loadMultiple($variant_ids);
    foreach ($variants as $variant) {
       /** @var \Drupal\media\Entity\Media */
       $media = $variant->get('art')->entity;
       /** @var \Drupal\file\Entity\File $file */
       $file = $media->get('field_media_image')->entity;
       $url = $this->urlGenerator->generateAbsoluteString($file->getFileUri());
      $result[] = [
        'cid' => (int) $cid,
        'vid' => (int) $variant->get('vid')->value,
        'art' => $url,
        'art_filename' => $variant->get('art_filename')->value,
        'rarity' => $variant->get('rarity')->value,
        'rarity_slug' => $variant->get('rarity_slug')->value,
        'variant_order' => $variant->get('variant_order')->value,
        'status' => $variant->get('status')->value,
        'full_description' => $variant->get('full_description')->value,
      ];
    }
    return $result;
  }

}
