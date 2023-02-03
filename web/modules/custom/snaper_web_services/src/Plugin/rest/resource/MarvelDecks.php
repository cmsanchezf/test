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
 *   id = "marvel_decks",
 *   label = @Translation("All Marvel Decks"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/marvel_decks"
 *   }
 * )
 */
class MarvelDecks extends ResourceBase {

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
    $cache_metadata->setCacheTags(['marvel_decks_all']);
    if ($cache = $this->cache->get('marvel_decks_all')) {
      $result = $cache->data;
      $cache_metadata->setCacheMaxAge(Cache::PERMANENT);
    }

    $query = $this->entityTypeManager->getStorage('marvel_deck')->getQuery();
    $query->condition('tags', '13');
    $marvel_deck_ids = $query->execute();
    /** @var \Drupal\marvel_deck\Entity\MarvelDeck[] $marvel_decks */
    $marvel_decks = $this->entityTypeManager->getStorage('marvel_deck')->loadMultiple($marvel_deck_ids);
    foreach ($marvel_decks as $marvel_deck) {
      $result[] = [
        "deck" => [
          'info' => [
            'did' => (int) $marvel_deck->get('did')->value,
            'user' => 'snapper',
            'display_name' => 'Snapper',
            'uid' => '',
            'name' => $marvel_deck->get('name')->value,
            'uuid' => '',
            'url' => '/deck/' . $marvel_deck->get('did')->value,
            'lastup' => (int) $marvel_deck->get('lastup')->value,
            'time_ago' => $marvel_deck->get('time_ago')->value,
            'slug' => $marvel_deck->get('slug')->value,
            'screenshot' => '',
            'description' => $marvel_deck->get('description')->value,
            'video' => '',
            'avatar' => '',
            'avg_power' => (int) $marvel_deck->get('avg_power')->value,
            'avg_cost' => (int) $marvel_deck->get('avg_cost')->value,
            'chart' => [
                'cost' => [],
                'power' => [],
            ],
            'code' => $marvel_deck->get('code')->value,
            // 'current_user_liked' => $marvel_deck->get('current_user_liked')->value,
            // 'total_likes' => $marvel_deck->get('total_likes')->value,
            // 'sources' => '',
            // 'tags' => '',
            // 'is_premium' => $marvel_deck->get('is_premium')->value,
            // 'is_creator' => $marvel_deck->get('is_creator')->value,
          ],
          'dekclist' => $this->getCards($marvel_deck->get('did')->value),
        ],
      ];
    }
    $this->cache->set('marvel_decks_all', $result, time() + 86400, ['marvel_decks_all']);
    // Create encoder with specified options as new default settings.
    return new ResourceResponse($result);
  }

  /**
   *
   */
  private function getCards($did) {
    $result = [];
    $query = $this->entityTypeManager->getStorage('marvel_deck')->getQuery();
    $query->condition('did', $did);
    $marvel_deck_ids = $query->execute();
    /** @var \Drupal\marvel_deck\Entity\MarvelDeck[] $marvel_decks */
    $marvel_decks = $this->entityTypeManager->getStorage('marvel_deck')->loadMultiple($marvel_deck_ids);

    $marvel_deck = reset($marvel_decks);
    /** @var \Drupal\Core\Field\EntityReferenceFieldItemList $field_item_list */
    $field_item_list = $marvel_deck->get('decklist');
    $referenced_entities = $field_item_list->referencedEntities();
    dump($referenced_entities);
    $ids = array_map(function ($item) {
      return $item->id();
    }, $referenced_entities);
    dump($ids);
    /**  @var \Drupal\marvel_card\Entity\MarvelCard[] $marvel_cards */
    $marvel_cards = $this->entityTypeManager->getStorage('marvel_card')->loadMultiple($ids);
    dump($marvel_cards);
    die;
    foreach ($marvel_cards as $marvel_card) {
      $result[] = [
        'cid' => (int) $marvel_card->get('cid')->value,
        'cname' => $marvel_card->get('name')->value,
        'type' => $marvel_card->get('type')->value,
        'art' => "https://snaper.ddev.site/sites/default/files/img/cards/" . str_replace(' ', '%20', $marvel_card->get('name')->value) . ".webp",
        'url' => '/card/' . $marvel_card->get('cid')->value,
        'ability' => $marvel_card->get('ability')->value,
        'cost' => (int) $marvel_card->get('cost')->value,
        'power' => (int) $marvel_card->get('power')->value,
        'carddefid' => $marvel_card->get('carddefid')->value,
        'uuid' => 0,
        'source' => $marvel_card->get('source')->value,
        'source_slug' => $marvel_card->get('source_slug')->value,
      ];
    }
  }

}
