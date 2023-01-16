<?php

namespace Drupal\marvel_card;

use Drupal\media\MediaInterface;
use Drupal\variant\Entity\Variant;
use Drupal\marvel_tag\Entity\MarvelTag;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a marvel card entity type.
 */
interface MarvelCardInterface extends ContentEntityInterface {

  /**
   * Set Marvel Card cid.
   *
   * @param int $cid
   *   The new cid.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setCid($cid);

  /**
   * Set Marvel Card name.
   *
   * @param string $name
   *   The new name.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setName($name);

  /**
   * Set Marvel Card type.
   *
   * @param string $type
   *   The new type.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setType($type);

  /**
   * Set Marvel Card cost.
   *
   * @param string $cost
   *   The new cost.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setCost($cost);

  /**
   * Set Marvel Card power.
   *
   * @param string $power
   *   The new power.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setPower($power);

  /**
   * Set Marvel Card ability.
   *
   * @param string $ability
   *   The new ability.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setAbility($ability);

  /**
   * Set Marvel Card art.
   *
   * @param \Drupal\media\MediaInterface $art
   *   The new art.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setArt(MediaInterface $art);

  /**
   * Set Marvel Card arternate_art.
   *
   * @param string $alternate_art
   *   The new alternate_art.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setAlternateArt($alternate_art);

  /**
   * Set Marvel Card url.
   *
   * @param string $url
   *   The new url.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setUrl($url);

  /**
   * Set Marvel Card status.
   *
   * @param string $status
   *   The new status.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setStatus($status);

  /**
   * Set Marvel Card carddefid.
   *
   * @param string $carddefid
   *   The new carddefid.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setCarddefid($carddefid);

  /**
   * Set Marvel Card variant.
   *
   * @param \Drupal\variant\Entity\Variant $variant
   *   The new variant.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setVariant(Variant $variant);

  /**
   * Set Marvel Card source.
   *
   * @param string $source
   *   The new source.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setSource($source);

  /**
   * Set Marvel Card source_slug.
   *
   * @param string $source_slug
   *   The new source_slug.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setSourceSlug($source_slug);

  /**
   * Set Marvel Card tag.
   *
   * @param \Drupal\marvel_tag\Entity\MarvelTag $tag
   *   The new tag.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setTag(MarvelTag $tag);

  /**
   * Set Marvel Card rarity.
   *
   * @param string $rarity
   *   The new rarity.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setRarity($rarity);

  /**
   * Set Marvel Card rarity_slug.
   *
   * @param string $rarity_slug
   *   The new rarity_slug.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setRaritySlug($rarity_slug);

  /**
   * Set Marvel Card difficulty.
   *
   * @param string $difficulty
   *   The new difficulty.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setDifficulty($difficulty);

  /**
   * Set Marvel Card created.
   *
   * @param string $created
   *   The new created.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setCreated($created);

  /**
   * Set Marvel Card changed.
   *
   * @param string $changed
   *   The new changed.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setChanged($changed);

}
