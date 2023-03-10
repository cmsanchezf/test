<?php

namespace Drupal\marvel_deck\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\marvel_deck\MarvelDeckInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the marvel deck entity class.
 *
 * @ContentEntityType(
 *   id = "marvel_deck",
 *   label = @Translation("Marvel deck"),
 *   label_collection = @Translation("Marvel decks"),
 *   label_singular = @Translation("marvel deck"),
 *   label_plural = @Translation("marvel decks"),
 *   label_count = @PluralTranslation(
 *     singular = "@count marvel decks",
 *     plural = "@count marvel decks",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\marvel_deck\MarvelDeckListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\marvel_deck\MarvelDeckAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\marvel_deck\Form\MarvelDeckForm",
 *       "edit" = "Drupal\marvel_deck\Form\MarvelDeckForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "marvel_deck",
 *   data_table = "marvel_deck_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer marvel deck",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/marvel-deck",
 *     "add-form" = "/marvel-deck/add",
 *     "canonical" = "/marvel-deck/{marvel_deck}",
 *     "edit-form" = "/marvel-deck/{marvel_deck}/edit",
 *     "delete-form" = "/marvel-deck/{marvel_deck}/delete",
 *   },
 *   field_ui_base_route = "entity.marvel_deck.settings",
 * )
 */
class MarvelDeck extends ContentEntityBase implements MarvelDeckInterface {

  /**
   * {@inheritdoc}
   */
  public function setDid($did) {
    $this->get('did')->value = $did;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAuthor($user) {
    $this->get('user')->appendItem($user);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAuthorName($name) {
    $this->get('display_name')->value = $name;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setUid($uid) {
    $this->get('uid')->value = $uid;
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
  public function setUrl($url) {
    $this->get('url')->value = $url;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setLastUp($lastUp) {
    $this->get('lastup')->value = $lastUp;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setSlug($slug) {
    $this->get('slug')->value = $slug;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setTimeAgo($created) {
    $this->get('time_ago')->value = $created;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setScreenshot($screenshot) {
    $this->get('screenshot')->appendItem($screenshot);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->get('description')->value = $description;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAvgPower($avg_power) {
    $this->get('avg_power')->value = $avg_power;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setAvgCost($avg_cost) {
    $this->get('avg_cost')->value = $avg_cost;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCode($code) {
    $this->get('code')->value = $code;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCard($card) {
    $this->get('decklist')->appendItem($card);
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
  public function setChart($chart) {
    $this->set('chart', $chart);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['did'] = BaseFieldDefinition::create('integer')
      ->setLabel(('Deck ID'))
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'number_decimal',
      ])
      ->setReadOnly(TRUE);

    $fields['user'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Username'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['display_name'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Display Name'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('User ID'))
      ->setSetting('min', 0)
      ->setSetting('max', 2000000000000000)
      ->setReadOnly(TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Deck Name'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['url'] = BaseFieldDefinition::create('uri')
      ->setLabel(new TranslatableMarkup('Deck URL'))
      ->setDisplayOptions('form', [
        'type' => 'uri',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['lastup'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Last Updated'))
      ->setReadOnly(TRUE);

    $fields['slug'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Games'))
      ->setSetting('min', 0)
      ->setSetting('max', 2000000000000000)
      ->setReadOnly(TRUE);

    $fields['time_ago'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Time Since Last Update'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['screenshot'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(new TranslatableMarkup('Deck Screenshot'))
      ->setDescription(new TranslatableMarkup('The screenshot of the Marvel Deck entity.'))
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

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(new TranslatableMarkup('Deck Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'text_default',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['video'] = BaseFieldDefinition::create('uri')
      ->setLabel(new TranslatableMarkup('Deck Video'))
      ->setDisplayOptions('form', [
        'type' => 'uri',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['avg_power'] = BaseFieldDefinition::create('float')
      ->setLabel(new TranslatableMarkup('Average Power'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_decimal',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['avg_cost'] = BaseFieldDefinition::create('float')
      ->setLabel(new TranslatableMarkup('Average Cost'))
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 7,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_decimal',
        'weight' => 7,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['chart'] = BaseFieldDefinition::create('map')
      ->setLabel(new TranslatableMarkup('Chart'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'map',
        'weight' => 8,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'map',
        'weight' => 8,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['code'] = BaseFieldDefinition::create('string_long')
      ->setLabel(new TranslatableMarkup('Code'))
      ->setSetting('is_ascii', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => 9,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 9,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['decklist'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(new TranslatableMarkup('Cards'))
      ->setDescription(new TranslatableMarkup('The Marvel Cards of the Marvel Deck entity.'))
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setSetting('target_type', 'marvel_card')
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

    return $fields;
  }

}
