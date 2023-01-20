<?php

namespace Drupal\marvel_deck;

use Drupal\user\Entity\User;
use Drupal\media\MediaInterface;
use Drupal\marvel_tag\Entity\MarvelTag;
use Drupal\marvel_card\Entity\MarvelCard;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a marvel deck entity type.
 */
interface MarvelDeckInterface extends ContentEntityInterface {

  /**
   * Set Marvel Deck did.
   *
   * @param int $did
   *   The new did.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setDid($did);

  /**
   * Set Marvel Deck variants.
   *
   * @param \Drupal\user\Entity\User $user
   *   The Author.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setAuthor(User $user);

  /**
   * Set Marvel Deck author's name.
   *
   * @param string $name
   *   The new author's name.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setAuthorName($name);

  /**
   * Set Marvel Deck uid.
   *
   * @param int $uid
   *   The new uid.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setUid($uid);

  /**
   * Set Marvel Deck name.
   *
   * @param string $name
   *   The new name.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setName($name);

  /**
   * Set Marvel Deck url.
   *
   * @param string $url
   *   The new url.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setUrl($url);

  /**
   * Set Marvel Deck last update.
   *
   * @param int $lastUp
   *   The last update time.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setLastUp($lastUp);

  /**
   * Set Marvel Deck slug.
   *
   * @param string $slug
   *   The new slug.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setSlug($slug);

  /**
   * Set Marvel Deck create time.
   *
   * @param int $created
   *   The created time.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setTimeAgo($created);

  /**
   * Set Marvel Card screenshot.
   *
   * @param \Drupal\media\MediaInterface $screenshot
   *   The new screenshot.
   *
   * @return $this
   *   The called marvel_card entity.
   */
  public function setScreenshot(MediaInterface $screenshot);

  /**
   * Set Marvel Deck description.
   *
   * @param string $description
   *   The new description.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setDescription($description);

  /**
   * Set Marvel Deck average power.
   *
   * @param int $avg_power
   *   The new average power.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setAvgPower($avg_power);

  /**
   * Set Marvel Deck average cost.
   *
   * @param int $avg_cost
   *   The new average cost.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setAvgCost($avg_cost);

  /**
   * Set Marvel Deck code.
   *
   * @param string $code
   *   The new code.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setCode($code);

  /**
   * Set Marvel Deck card.
   *
   * @param \Drupal\marvel_card\Entity\MarvelCard $card
   *   One card of the deck.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setCard(MarvelCard $card);

  /**
   * Set Marvel Deck tag.
   *
   * @param \Drupal\marvel_tag\Entity\MarvelTag $tag
   *   The new tag.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setTag(MarvelTag $tag);

  /**
   * Set Marvel Deck chart.
   *
   * @param array $chart
   *   The charts of the deck.
   *
   * @return $this
   *   The called marvel_deck entity.
   */
  public function setChart(array $chart);

}
