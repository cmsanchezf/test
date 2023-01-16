<?php

namespace Drupal\marvel_tag;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a marvel tag entity type.
 */
interface MarvelTagInterface extends ContentEntityInterface {

  /**
   * Set Marvel Tag id.
   *
   * @param int $id
   *   The new id.
   *
   * @return $this
   *   The called marvel_tag entity.
   */
  public function setId($id);

  /**
   * Set Marvel Card tag.
   *
   * @param string $tag
   *   The new tag.
   *
   * @return $this
   *   The called marvel_tag entity.
   */
  public function setTag($tag);

  /**
   * Set Marvel Card tag_slug.
   *
   * @param string $tag_slug
   *   The new tag_slug.
   *
   * @return $this
   *   The called marvel_tag entity.
   */
  public function setTagSlug($tag_slug);

}
