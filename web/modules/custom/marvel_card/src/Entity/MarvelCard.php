<?php

namespace Drupal\marvel_card\Entity;

use Drupal\media\MediaInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\marvel_card\MarvelCardInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

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
   * {@inheritdoc}
   */
  public function setCid($cid) {
    $this->get('cid')->value = $cid;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->get('name')->value = $name;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setType($type) {
    $this->get('type')->value = $type;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCost($cost) {
    $this->get('cost')->value = $cost;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setPower($power) {
    $this->get('power')->value = $power;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAbility($ability) {
    $this->get('ability')->value = $ability;
    return $this;
  }

    /**
   * {@inheritdoc}
   */
  public function setFlavor($flavor) {
    $this->get('flavor')->value = $flavor;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setArt(MediaInterface $art) {
    $this->get('art')->appendItem($art);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAlternateArt($alternate_art) {
    $this->get('alternate_art')->value = $alternate_art;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setUrl($url) {
    $this->get('url')->value = $url;
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
  public function setCarddefid($carddefid) {
    $this->get('carddefid')->value = $carddefid;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setVariant($variant) {
    $this->get('variants')->appendItem($variant);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setSource($source) {
    $this->get('source')->value = $source;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setSourceSlug($source_slug) {
    $this->get('source_slug')->value = $source_slug;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setTag($tag) {
    $this->get('tags')->appendItem($tag);
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
  public function setDifficulty($difficulty) {
    $this->get('difficulty')->value = $difficulty;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreated($created) {
    $this->get('created')->value = $created;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setChanged($changed) {
    $this->get('changed')->value = $changed;
    return $this;
  }

  public function getCost() {
    return $this->get('cost')->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['cid'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('CID'))
      ->setDescription(new TranslatableMarkup('The cost of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Name'))
      ->setDescription(new TranslatableMarkup('The name of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Type'))
      ->setDescription(new TranslatableMarkup('The type of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Cost'))
      ->setDescription(new TranslatableMarkup('The cost of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Power'))
      ->setDescription(new TranslatableMarkup('The power of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Ability'))
      ->setDescription(new TranslatableMarkup('The ability of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Flavor'))
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

    $fields['alternate_art'] = BaseFieldDefinition::create('string_long')
    ->setLabel(new TranslatableMarkup('Alternate Art'))
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

    $fields['url'] = BaseFieldDefinition::create('uri')
      ->setLabel(new TranslatableMarkup('URL'))
      ->setDescription(new TranslatableMarkup('The URL of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Publishing status'))
      ->setDescription(new TranslatableMarkup('A boolean indicating whether the Card is published.'))
      ->setRevisionable(FALSE)
      ->setDefaultValue(TRUE);

    $fields['carddefid'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Card ID'))
      ->setDescription(new TranslatableMarkup('The card ID of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Variants'))
      ->setDescription(new TranslatableMarkup('The variants of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Source'))
      ->setDescription(new TranslatableMarkup('The source of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Source Slug'))
      ->setDescription(new TranslatableMarkup('The source slug of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['tags'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(new TranslatableMarkup('Tags'))
      ->setDescription(new TranslatableMarkup('The tags of the Marvel Card entity.'))
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
      ->setLabel(new TranslatableMarkup('Rarity'))
      ->setDescription(new TranslatableMarkup('The rarity of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Rarity Slug'))
      ->setDescription(new TranslatableMarkup('The rarity slug of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Difficulty'))
      ->setDescription(new TranslatableMarkup('The difficulty of the Marvel Card entity.'))
      ->setRevisionable(FALSE)
      ->setSettings([
        'max_length' => 255,
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
      ->setLabel(new TranslatableMarkup('Created'))
      ->setDescription(new TranslatableMarkup('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(new TranslatableMarkup('Changed'))
      ->setDescription(new TranslatableMarkup('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(new TranslatableMarkup('Revision translation affected'))
      ->setDescription(new TranslatableMarkup('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(FALSE)
      ->setTranslatable(TRUE);

    return $fields;

  }

}
