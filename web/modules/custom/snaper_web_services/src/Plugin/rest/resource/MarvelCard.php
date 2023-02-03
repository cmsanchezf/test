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
 *   id = "marvel_card",
 *   label = @Translation("Marvel Cards by id"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/marvel_card/{cid}"
 *   }
 * )
 */
class MarvelCard extends ResourceBase {

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
   * Function to set permissions.
   */
  public function permissions() {
    return [];
  }

  /**
   * Responds to GET requests.
   *
   * @param string $cid
   *   Returns a simple "Hello World" message.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   */
  public function get(string $cid) {
    // Ensure that the user has permission to access this resource.
    if (!$this->accountProxy->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    /** @var array $result */
    $result = [];
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheTags(['card:' . $cid]);
    if ($cache = $this->cache->get('marvel_card_' . $cid)) {
      $result = $cache->data;
      $cache_metadata->setCacheMaxAge(Cache::PERMANENT);
    }
    $query = $this->entityTypeManager->getStorage('marvel_card')->getQuery();
    $query->condition('cid', $cid);
    $marvel_card_ids = $query->execute();
    /** @var \Drupal\marvel_card\Entity\MarvelCard[] $marvel_cards */
    $marvel_cards = $this->entityTypeManager->getStorage('marvel_card')->loadMultiple($marvel_card_ids);
    /** @var \Drupal\marvel_card\Entity\MarvelCard $marvel_card */
    $marvel_card = reset($marvel_cards);
    /** @var \Drupal\Core\Field\EntityReferenceFieldItemList $field_item_list */
    $field_item_list = $marvel_card->get('tags');
    $referenced_entities = $field_item_list->referencedEntities();
    $ids = array_map(function ($item) {
      return $item->id();
    }, $referenced_entities);
    /** @var \Drupal\marvel_tag\Entity\MarvelTag[] $tag */
    $tag = $this->entityTypeManager->getStorage('marvel_tag')->loadMultiple($ids);
    $tags = [];
    if (!empty($tag)) {
      $tags[] = [
        'tag_id' => reset($tag)->get('tag_id')->value,
        'tag' => reset($tag)->get('tag')->value,
        'tag_slug' => reset($tag)->get('tag_slug')->value,
      ];
    }
    $result = [
      'cid' => (int) $marvel_card->get('cid')->value,
      'name' => $marvel_card->get('name')->value,
      'type' => $marvel_card->get('type')->value,
      'cost' => (int) $marvel_card->get('cost')->value,
      'power' => (int) $marvel_card->get('power')->value,
      'ability' => $marvel_card->get('ability')->value,
      'flavor' => $marvel_card->get('flavor')->value,
      'art' => "https://snaper.ddev.site/sites/default/files/img/cards/" . str_replace(' ', '%20', $marvel_card->get('name')->value) . ".webp",
      'alternate_art' => '',
      'url' => '/card/' . $marvel_card->get('cid')->value,
      'status' => $marvel_card->get('status')->value,
      'carddefid' => $marvel_card->get('carddefid')->value,
      'source' => $marvel_card->get('source')->value,
      'source_slug' => $marvel_card->get('source_slug')->value,
      'tags' => $tags,
      'rarity' => $marvel_card->get('rarity')->value,
      'rarity_slug' => $marvel_card->get('rarity_slug')->value,
      'difficulty' => $marvel_card->get('difficulty')->value,
    ];

    $this->cache->set('marvel_card_' . $cid, $result, Cache::PERMANENT, ['card:' . $cid]);
    // Create encoder with specified options as new default settings.
    return new ResourceResponse($result);
  }

}
