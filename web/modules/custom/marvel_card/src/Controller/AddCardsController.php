<?php

namespace Drupal\marvel_card\Controller;

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\Core\Controller\ControllerBase;

/**
 * This controller is for the routes of the races of the project.
 */
class AddCardsController extends ControllerBase {

  /**
   * Function to get all cards information from endpoint.
   */
  public function add() {
    // Deleting entities.
    // $storage = $this->entityTypeManager()->getStorage('marvel_card');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // $storage = $this->entityTypeManager()->getStorage('marvel_deck');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // $storage = $this->entityTypeManager()->getStorage('variant');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // $storage = $this->entityTypeManager()->getStorage('marvel_tag');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // $storage = $this->entityTypeManager()->getStorage('file');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // $storage = $this->entityTypeManager()->getStorage('media');
    // $entities = $storage->loadMultiple();
    // $storage->delete($entities);
    // die;
    // // Check if a marvel card with the same cid already exists.
    $url = 'https://marvelsnapzone.com/getinfo/?searchtype=cards&searchcardstype=true';
    $response = file_get_contents($url);
    $cards = NULL;
    /** @var \Drupal\media\MediaInterface $media */
    $media = NULL;
    /** @var \Drupal\file\Entity\File $file */
    $file = NULL;
    $marvel_card = NULL;
    $iterator = 0;
    $iterator2 = 0;
    $iterator3 = 0;
    if (http_response_code() == 200) {
      // Request was successful.
      $cards = json_decode($response, TRUE)['success']['cards'];
      foreach ($cards as $card) {
        $query = $this->entityTypeManager()->getStorage('marvel_card')
          ->getQuery()
          ->accessCheck()
          ->condition('cid', $card['cid']);
        $uids = $query->execute();
        $current_card = $this->entityTypeManager()->getStorage('marvel_card')
          ->loadMultiple($uids);
        if (empty($current_card)) {
          $image_url = $card['art'];
          $image_data = file_get_contents($image_url);
          $file_name = $card['name'] . '.webp';
          $file = File::create([
            'uri' => 'public://img/cards/' . $file_name,
          ]);
          $file->setFileUri('public://img/cards/' . $file_name);
          $file->setFilename($file_name);
          $file->setPermanent();
          // Save the image data to the file.
          file_put_contents($file->getFileUri(), $image_data);
          $saved = $file->save();
          if ($saved) {
            $media = Media::create([
              'bundle' => 'image',
              'field_media_image' => [
                'target_id' => $file->id(),
              ],
            ]);
            $media->save();
          }

          /** @var \Drupal\marvel_card\Entity\MarvelCard $marvel_card */
          $marvel_card = $this->entityTypeManager()->getStorage('marvel_card')->create([]);
          $marvel_card->setCid($card['cid']);
          $marvel_card->setName($card['name']);
          $marvel_card->setType($card['type']);
          $marvel_card->setCost($card['cost']);
          $marvel_card->setPower($card['power']);
          $marvel_card->setAbility($card['ability']);
          $marvel_card->setFlavor($card['flavor']);
          $marvel_card->setArt($media);
          $marvel_card->setAlternateArt($card['alternate_art']);
          $marvel_card->setUrl($card['url']);
          $marvel_card->setStatus($card['status']);
          $marvel_card->setCarddefid($card['carddefid']);
          $marvel_card->setSource($card['source']);
          $marvel_card->setSourceSlug($card['source_slug']);
          $marvel_card->setRarity($card['rarity']);
          $marvel_card->setRaritySlug($card['rarity_slug']);
          $marvel_card->setDifficulty($card['difficulty']);
          $iterator++;
          foreach ($card['variants'] as $variant_data) {
            $query = $this->entityTypeManager()->getStorage('variant')
              ->getQuery()
              ->accessCheck()
              ->condition('vid', $variant_data['vid']);
            $uids = $query->execute();
            $current_variant = $this->entityTypeManager()->getStorage('variant')
              ->loadMultiple($uids);
            if (empty($current_variant)) {
              $image_url = $variant_data['art'];
              $image_data = file_get_contents($image_url);
              $file_name = $card['name'] . '_' . $variant_data['variant_order'] . '.webp';
              $file = File::create([
                'uri' => 'public://img/variants/' . $file_name,
              ]);
              $file->setFileUri('public://img/variants/' . $file_name);
              $file->setFilename($file_name);
              $file->setPermanent();
              // Save the image data to the file.
              file_put_contents($file->getFileUri(), $image_data);
              $saved = $file->save();
              if ($saved) {
                $media = Media::create([
                  'bundle' => 'image',
                  'field_media_image' => [
                    'target_id' => $file->id(),
                  ],
                ]);
                $media->save();
              }
              /** @var \Drupal\variant\Entity\Variant $variant */
              $variant = $this->entityTypeManager()->getStorage('variant')->create([]);
              $variant->setCid($variant_data['cid']);
              $variant->setVid($variant_data['vid']);
              $variant->setArt($media);
              $variant->setFileName($variant_data['art_filename']);
              $variant->setRarity($variant_data['rarity']);
              $variant->setRaritySlug($variant_data['rarity_slug']);
              $variant->setVariantOrder($variant_data['variant_order']);
              $variant->setFullDescription($variant_data['full_description']);
              $variant->setStatus($variant_data['status']);
              $variant->save();
              $marvel_card->setVariant($variant);
              $iterator2++;
            }
          }

          foreach ($card['tags'] as $tag_data) {
            $query = $this->entityTypeManager()->getStorage('marvel_tag')
              ->getQuery()
              ->accessCheck()
              ->condition('tag_id', $tag_data['tag_id']);
            $uids = $query->execute();
            /** @var \Drupal\marvel_tag\Entity\MarvelTag[] $tag_exists */
            $tag_exists = $this->entityTypeManager()->getStorage('marvel_tag')
              ->loadMultiple($uids);
            if (empty($tag_exists)) {
              /** @var \Drupal\marvel_tag\Entity\MarvelTag $tag */
              $tag = $this->entityTypeManager()->getStorage('marvel_tag')->create([]);
              $tag->setId($tag_data['tag_id']);
              $tag->setTag($tag_data['tag']);
              $tag->setTagSlug($tag_data['tag_slug']);
              $tag->save();
              $marvel_card->setTag($tag);
              $iterator3++;
            }else {
              $marvel_card->setTag(reset($tag_exists));
            }
          }
          $marvel_card->save();
        }
      }
    }
    else {
      // Request was not successful
      // handle the error.
    }
    dump('Cards added: ' . $iterator, 'Variants added: ' . $iterator2, 'Tags added:' . $iterator3);
  }

}
