<?php

namespace Drupal\marvel_card;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the marvel card entity type.
 */
class MarvelCardListBuilder extends EntityListBuilder {

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

    $build['summary']['#markup'] = $this->t('Total marvel cards: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['cid'] = $this->t('CID');
    $header['name'] = $this->t('NAME');
    $header['type'] = $this->t('TYPE');
    $header['source'] = $this->t('SOURCE');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\marvel_card\MarvelCardInterface $entity */
    $row['id'] = $entity->toLink();
    $row['cid'] = $entity->get('cid')->value;
    $row['name'] = $entity->get('name')->value;
    $row['type'] = $entity->get('type')->value;
    $row['source'] = $entity->get('source')->value;
    return $row + parent::buildRow($entity);
  }

}
