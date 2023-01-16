<?php

namespace Drupal\variant;

use Drupal\media\MediaInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a variant entity type.
 */
interface VariantInterface extends ContentEntityInterface {

  /**
   * Set Variant Card cid.
   *
   * @param int $cid
   *   The new cid.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setCid($cid);

  /**
   * Set Variant Card vid.
   *
   * @param int $vid
   *   The new vid.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setVid($vid);

  /**
   * Set Variant Card art.
   *
   * @param \Drupal\media\MediaInterface $art
   *   The new art.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setArt(MediaInterface $art);

  /**
   * Set Variant Card art_filename.
   *
   * @param string $art_filename
   *   The new art_filename.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setFileName($art_filename);

  /**
   * Set Variant Card rarity.
   *
   * @param string $rarity
   *   The new rarity.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setRarity($rarity);

  /**
   * Set Variant Card rarity_slug.
   *
   * @param string $rarity_slug
   *   The new rarity_slug.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setRaritySlug($rarity_slug);

  /**
   * Set Variant Card variant_order.
   *
   * @param string $variant_order
   *   The new variant_order.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setVariantOrder($variant_order);

  /**
   * Set Variant Card full_description.
   *
   * @param string $full_description
   *   The new full_description.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setFullDescription($full_description);

  /**
   * Set Variant Card status.
   *
   * @param string $status
   *   The new status.
   *
   * @return $this
   *   The called variant entity.
   */
  public function setStatus($status);

}
