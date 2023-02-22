<?php

namespace Drupal\marvel_tag;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the marvel tag entity type.
 */
class MarvelTagListBuilder extends EntityListBuilder {

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

    $build['summary']['#markup'] = $this->t('Total marvel tags: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['tag_id'] = $this->t('TAG ID');
    $header['tag'] = $this->t('TAG');
    $header['tag_slug'] = $this->t('SLUG');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\marvel_tag\MarvelTagInterface $entity */
    $row['id'] = $entity->toLink();
    $row['tag_id'] = $entity->get('tag_id')->value;
    $row['tag'] = $entity->get('tag')->value;
    $row['tag_slug'] = $entity->get('tag_slug')->value;
    return $row + parent::buildRow($entity);
  }

}
