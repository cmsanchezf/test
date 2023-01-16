<?php

namespace Drupal\marvel_tag\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\marvel_tag\MarvelTagInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the marvel tag entity class.
 *
 * @ContentEntityType(
 *   id = "marvel_tag",
 *   label = @Translation("Marvel tag"),
 *   label_collection = @Translation("Marvel tags"),
 *   label_singular = @Translation("marvel tag"),
 *   label_plural = @Translation("marvel tags"),
 *   label_count = @PluralTranslation(
 *     singular = "@count marvel tags",
 *     plural = "@count marvel tags",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\marvel_tag\MarvelTagListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\marvel_tag\Form\MarvelTagForm",
 *       "edit" = "Drupal\marvel_tag\Form\MarvelTagForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "marvel_tag",
 *   admin_permission = "administer marvel tag",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/marvel-tag",
 *     "add-form" = "/marvel-tag/add",
 *     "canonical" = "/marvel-tag/{marvel_tag}",
 *     "edit-form" = "/marvel-tag/{marvel_tag}/edit",
 *     "delete-form" = "/marvel-tag/{marvel_tag}/delete",
 *   },
 *   field_ui_base_route = "entity.marvel_tag.settings",
 * )
 */
class MarvelTag extends ContentEntityBase implements MarvelTagInterface {

  /**
   * {@inheritdoc}
   */
  public function setId($id) {
    $this->get('tag_id')->value = $id;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setTag($tag) {
    $this->get('tag')->value = $tag;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setTagSlug($tag_slug) {
    $this->get('tag_slug')->value = $tag_slug;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['tag_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Cost'))
      ->setDescription(new TranslatableMarkup('The id of the Marvel Tag entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue(0)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'integer',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['tag'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Tag'))
      ->setDescription(new TranslatableMarkup('The tag of the Marvel Tag entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['tag_slug'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Tag Slug'))
      ->setDescription(new TranslatableMarkup('The tag slug of the Marvel Tag entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
