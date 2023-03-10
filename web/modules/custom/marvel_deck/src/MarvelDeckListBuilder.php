<?php

namespace Drupal\marvel_deck;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the marvel deck entity type.
 */
class MarvelDeckListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['table'] = parent::render();

    $total = $this->getStorage()
      ->getQuery()
      ->accessCheck(FALSE)
      ->count()
      ->execute();

      $build['summary']['#markup'] = $this->t('Total marvel decks: @total', ['@total' => $total]);

      $build['#header'] = [
        'data' => $this->buildHeader(),
        'class' => ['table-header'],
      ];

      $build['#tabledrag'] = [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'marvel-deck-order-weight',
        ],
      ];
      
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['did'] = $this->t('Deck ID');
    $header['slug'] = [
      'data' => $this->t('Games'),
      'field' => 'slug',
      'specifier' => 'slug',
      'sort' => true,
    ];
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\marvel_deck\MarvelDeckInterface $entity */
    $row['id'] = $entity->toLink();
    $row['did'] = $entity->get('did')->value;
    $row['slug'] = $entity->get('slug')->value;
    $row['name'] = $entity->get('name')->value;
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getSortFields() {
    $fields = [
      'slug' => $this->t('Games'),
    ]; 

    return $fields;
  }

}
