<?php

namespace Drupal\marvel_deck\Controller;

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\Core\Controller\ControllerBase;

/**
 * This controller is for the routes of the races of the project.
 */
class DecksController extends ControllerBase {

  /**
   * Function to get decks information from endpoint.
   */
  public function add() {
    for ($j = 100; $j < 200; $j++) {
      $iterator = 0;
      // code...
      for ($i = 0; $i <= 200; $i++) {
        $loop = (string) $i;
        $tag = (string) $j;
        $url = "https://marvelsnapzone.com/getinfo/?searchdecks=true&tags=[]&cardtags=[]&deckname=&abilities=[]&sources=[]&cards=[" . $tag . "]&collection=[]&onlywithlikes=0&onlywithvideo=0&onlycontentcreators=0&onlynonanonymous=0&sorttype=updated&sortorder=asc&nextpage=" . $loop;
        dump($url);
        $break = FALSE;
        $response = file_get_contents($url);
        $decks = NULL;
        $marvel_deck = NULL;
        $media = NULL;
        if (http_response_code() == 200) {
          // Request was successful.
          $decks = json_decode($response, TRUE)['success']['decks'];
          dump($decks[0]);
          if (empty($decks)) {
            $break = TRUE;
            break;
          }
          foreach ($decks as $deck) {
            $query = $this->entityTypeManager()->getStorage('marvel_deck')
              ->getQuery()
              ->accessCheck()
              ->condition('did', $deck['deck']['info']['did']);
            $uids = $query->execute();
            $current_deck = $this->entityTypeManager()->getStorage('marvel_deck')
              ->loadMultiple($uids);
            if (empty($current_deck)) {
              $id = $this->currentUser()->id();
              $storage = $this->entityTypeManager->getStorage('user');
              /** @var \Drupal\user\Entity\User $user */
              $user = $storage->load($id);
              /** @var \Drupal\marvel_deck\Entity\MarvelDeck $marvel_deck */
              $marvel_deck = $this->entityTypeManager()->getStorage('marvel_deck')->create([]);
              $marvel_deck->setDid($deck['deck']['info']['did']);
              // $marvel_deck->setAuthor($user);
              $marvel_deck->setAuthorName($deck['deck']['info']['display_name']);
              // $marvel_deck->setUid($deck['deck']['info']['uuid']);
              $name = trim(preg_replace('/[^a-zA-Z0-9?!., ]/', '', $deck['deck']['info']['name']));
              $marvel_deck->setName($name);
              $marvel_deck->setUrl($deck['deck']['info']['url']);
              $marvel_deck->setLastUp($deck['deck']['info']['lastup']);
              $marvel_deck->setSlug($deck['deck']['info']['slug']);
              $marvel_deck->setTimeAgo($deck['deck']['info']['time_ago']);
              // $marvel_deck->setDescription($deck['deck']['info']['description']);
              $marvel_deck->setAvgCost($deck['deck']['info']['avg_cost']);
              $marvel_deck->setAvgPower($deck['deck']['info']['avg_power']);
              $marvel_deck->setCode($deck['deck']['info']['code']);
              $marvel_deck->setChart($deck['deck']['info']['chart']);
              foreach ($deck['deck']['info']['tags'] as $tag_data) {
                $query = $this->entityTypeManager()->getStorage('marvel_tag')
                  ->getQuery()
                  ->accessCheck()
                  ->condition('tag_id', $tag_data['tag_id']);
                $uids = $query->execute();

                /** @var \Drupal\marvel_tag\Entity\MarvelTag|null $tag_exists */
                $tag_exists = $this->entityTypeManager()->getStorage('marvel_tag')
                  ->loadMultiple($uids);
                $tag = NULL;
                if (empty($tag_exists)) {
                  /** @var \Drupal\marvel_tag\Entity\MarvelTag $tag */
                  $tag = $this->entityTypeManager()->getStorage('marvel_tag')->create([]);
                  $tag->setId($tag_data['tag_id']);
                  $tag->setTag($tag_data['tag']);
                  $tag->setTagSlug($tag_data['tag_slug']);
                  $tag->save();
                  $marvel_deck->setTag($tag);
                }
                else {
                  $marvel_deck->setTag(current($tag_exists));
                }
              }
              foreach ($deck['deck']['decklist']['cards'] as $card) {
                $query = $this->entityTypeManager()->getStorage('marvel_card')
                  ->getQuery()
                  ->accessCheck()
                  ->condition('cid', $card['cid']);
                $uids = $query->execute();
                /** @var \Drupal\marvel_card\Entity\MarvelCard */
                $current_card = $this->entityTypeManager()->getStorage('marvel_card')
                  ->loadMultiple($uids);
                $marvel_deck->setCard(current($current_card));
              }

              // $screenshot_url = $deck['deck']['info']['screenshot'];
              // $screenshot_data = file_get_contents($screenshot_url);
              // $file_name = $deck['deck']['info']['uuid'] . '.webp';
              // $file = File::create([
              //   'uri' => 'public://img/decks/' . $file_name,
              // ]);
              // $file->setFileUri('public://img/decks/' . $file_name);
              // $file->setFilename($file_name);
              // $file->setPermanent();
              // // Save the screenshot data to the file.
              // file_put_contents($file->getFileUri(), $screenshot_data);
              // $saved = $file->save();
              // if ($saved) {
              //   $media = Media::create([
              //     'bundle' => 'image',
              //     'field_media_image' => [
              //       'target_id' => $file->id(),
              //     ],
              //   ]);
              //   $media->save();
              // }
              // $marvel_deck->setScreenshot($media);
              $marvel_deck->save();
              $iterator++;
            }
          }
        }
        if ($break) {
          break;
        }
      }
      dump('Decks added: ' . $iterator . 'for card:' .$tag. ' in a total of:'.$loop.'loops.'); 
    }
  }

}
