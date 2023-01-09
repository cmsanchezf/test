<?php

namespace Drupal\marvel_card\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\marvel_card\MarvelCardInterface;

/**
 * Defines the marvel Marvel card entity class.
 *
 * @ContentEntityType(
 *   id = "marvel_card",
 *   label = @Translation("Marvel card"),
 *   label_collection = @Translation("Marvel cards"),
 *   label_singular = @Translation("marvel card"),
 *   label_plural = @Translation("marvel cards"),
 *   label_count = @PluralTranslation(
 *     singular = "@count marvel cards",
 *     plural = "@count marvel cards",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\marvel_card\MarvelCardListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\marvel_card\MarvelCardAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\marvel_card\Form\MarvelCardForm",
 *       "edit" = "Drupal\marvel_card\Form\MarvelCardForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "marvel_card",
 *   data_table = "marvel_card_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer marvel card",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/marvel-card",
 *     "add-form" = "/marvel-card/add",
 *     "canonical" = "/marvel-card/{marvel_card}",
 *     "edit-form" = "/marvel-card/{marvel_card}/edit",
 *     "delete-form" = "/marvel-card/{marvel_card}/delete",
 *   },
 *   field_ui_base_route = "entity.marvel_card.settings",
 * )
 */
class MarvelCard extends ContentEntityBase implements MarvelCardInterface {

  /**
   *
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['cid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('CID'))
      ->setDescription(t('The cost of the Marvel Card entity.'))
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

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Marvel Card entity.'))
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

    $fields['type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Type'))
      ->setDescription(t('The type of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['cost'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Cost'))
      ->setDescription(t('The cost of the Marvel Card entity.'))
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

    $fields['power'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Power'))
      ->setDescription(t('The power of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue(0)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'integer',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['ability'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Ability'))
      ->setDescription(t('The ability of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string_long',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['flavor'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Flavor'))
      ->setDescription(t('The flavor text of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string_long',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

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

    $fields['alternate_art'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('Alternate Art'))
      ->setDescription(t('The alternate art image URL of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => 3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image_image',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['url'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('URL'))
      ->setDescription(t('The URL of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'uri',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Card is published.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue(TRUE);

    $fields['carddefid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Card ID'))
      ->setDescription(t('The card ID of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
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

    $fields['variants'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Variants'))
      ->setDescription(t('The variants of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setSetting('target_type', 'variant')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['source'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source'))
      ->setDescription(t('The source of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 7,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 7,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['source_slug'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source Slug'))
      ->setDescription(t('The source slug of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['tags'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Tags'))
      ->setDescription(t('The tags of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setSetting('target_type', 'marvel_tag')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_label',
        'weight' => 9,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 9,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['rarity'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Rarity'))
      ->setDescription(t('The rarity of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 10,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['rarity_slug'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Rarity Slug'))
      ->setDescription(t('The rarity slug of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 11,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 11,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['difficulty'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Difficulty'))
      ->setDescription(t('The difficulty of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 12,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 12,
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
      ->setRevisionable(FALSE)
      ->setTranslatable(TRUE);

    return $fields;

  }

}
