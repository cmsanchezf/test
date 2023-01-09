<?php

namespace Drupal\variant\Entity;

use Drupal\variant\VariantInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the variant entity class.
 *
 * @ContentEntityType(
 *   id = "variant",
 *   label = @Translation("Variant"),
 *   label_collection = @Translation("Variants"),
 *   label_singular = @Translation("variant"),
 *   label_plural = @Translation("variants"),
 *   label_count = @PluralTranslation(
 *     singular = "@count variants",
 *     plural = "@count variants",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\variant\VariantListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\variant\VariantAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\variant\Form\VariantForm",
 *       "edit" = "Drupal\variant\Form\VariantForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "variant",
 *   data_table = "variant_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer variant",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/variant",
 *     "add-form" = "/variant/add",
 *     "canonical" = "/variant/{variant}",
 *     "edit-form" = "/variant/{variant}/edit",
 *     "delete-form" = "/variant/{variant}/delete",
 *   },
 *   field_ui_base_route = "entity.variant.settings",
 * )
 */
class Variant extends ContentEntityBase implements VariantInterface {

  /**
   *
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['cid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('CID'))
      ->setDescription(t('The Card entity to which the Variant belongs.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'marvel_card')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['vid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Variant ID'))
      ->setDescription(t('The variant ID of the Variant entity.'))
      ->setReadOnly(TRUE);

    $fields['art'] = BaseFieldDefinition::create('entity_reference')
    ->setLabel(t('Art'))
    ->setDescription(t('The art image of the Marvel Card entity.'))
    ->setRevisionable(FALSE)
    ->setSetting('target_type', 'media')
    ->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'image',
      'weight' => 2,
    ])
    ->setDisplayOptions('form', [
      'type' => 'media_thumbnail',
      'weight' => 2,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);

    $fields['art_filename'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Art Filename'))
      ->setDescription(t('The art filename of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['rarity'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Rarity'))
      ->setDescription(t('The ratity of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['rarity_slug'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Rarity Slug'))
      ->setDescription(t('The rarity slug of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['variant_order'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Variant Order'))
      ->setDescription(t('The variant order of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    $fields['status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Status'))
      ->setDescription(t('The status of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['full_description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Full Description'))
      ->setDescription(t('The full description of the Variant entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 7,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textfield',
        'weight' => 7,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
