<?php

namespace Drupal\variant\Entity;

use Drupal\variant\VariantInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

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
   * {@inheritdoc}
   */
  public function setCid($cid) {
    $this->get('cid')->value = $cid;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setVid($vid) {
    $this->get('vid')->value = $vid;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setArt($art) {
    $this->get('art')->appendItem($art);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setFileName($art_filename) {
    $this->get('art_filename')->value = $art_filename;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setRarity($rarity) {
    $this->get('rarity')->value = $rarity;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setRaritySlug($rarity_slug) {
    $this->get('rarity_slug')->value = $rarity_slug;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setVariantOrder($variant_order) {
    $this->get('variant_order')->value = $variant_order;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setFullDescription($full_description) {
    $this->get('full_description')->value = $full_description;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->get('status')->value = $status;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['cid'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('CID'))
      ->setDescription(new TranslatableMarkup('The Card entity to which the Variant belongs.'))
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

    $fields['vid'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Variant ID'))
      ->setDescription(new TranslatableMarkup('The variant ID of the Variant entity.'))
      ->setReadOnly(TRUE);

    $fields['art'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(new TranslatableMarkup('Art'))
      ->setDescription(new TranslatableMarkup('The art image of the Marvel Card entity.'))
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

    $fields['art_filename'] = BaseFieldDefinition::create('string_long')
    ->setLabel(new TranslatableMarkup('Art Filename'))
    ->setDescription(new TranslatableMarkup('The flavor text of the Marvel Card entity.'))
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

    $fields['rarity'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Rarity'))
      ->setDescription(new TranslatableMarkup('The ratity of the Variant entity.'))
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
      ->setLabel(new TranslatableMarkup('Rarity Slug'))
      ->setDescription(new TranslatableMarkup('The rarity slug of the Variant entity.'))
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
      ->setLabel(new TranslatableMarkup('Variant Order'))
      ->setDescription(new TranslatableMarkup('The variant order of the Variant entity.'))
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
      ->setLabel(new TranslatableMarkup('Status'))
      ->setDescription(new TranslatableMarkup('The status of the Variant entity.'))
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
      ->setLabel(new TranslatableMarkup('Full Description'))
      ->setDescription(new TranslatableMarkup('The full description of the Variant entity.'))
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
      ->setLabel(new TranslatableMarkup('Created'))
      ->setDescription(new TranslatableMarkup('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(new TranslatableMarkup('Changed'))
      ->setDescription(new TranslatableMarkup('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(new TranslatableMarkup('Revision translation affected'))
      ->setDescription(new TranslatableMarkup('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
