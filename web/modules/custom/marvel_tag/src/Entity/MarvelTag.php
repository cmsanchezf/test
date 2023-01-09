<?php

namespace Drupal\marvel_tag\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\marvel_tag\MarvelTagInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;

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
   *
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['tag_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Cost'))
      ->setDescription(t('The id of the Marvel Tag entity.'))
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
      ->setLabel(t('Tag'))
      ->setDescription(t('The tag of the Marvel Tag entity.'))
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
      ->setLabel(t('Tag Slug'))
      ->setDescription(t('The tag slug of the Marvel Tag entity.'))
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
