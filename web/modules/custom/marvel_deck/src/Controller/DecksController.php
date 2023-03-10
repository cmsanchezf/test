<?php
namespace Drupal\marvel_deck\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This controller is for the routes of the races of the project.
 */
class DecksController extends ControllerBase {

  /**
   * Function to get decks information from endpoint marvelsnapzone.
   */
  public function add() {
    $break = FALSE;
    for ($j = 1; $j < 300; $j++) {
      $iterator = 0;
      // code...
      for ($i = 0; $i <= 200; $i++) {
        $loop = (string) $i;
        $tag = (string) $j;
        $url = "https://marvelsnapzone.com/getinfo/?searchdecks=true&tags=[]&cardtags=[]&deckname=&abilities=[]&sources=[]&cards=[" . $tag . "]&collection=[]&onlywithlikes=0&onlywithvideo=0&onlycontentcreators=0&onlynonanonymous=0&sorttype=updated&sortorder=asc&nextpage=" . $loop;
        dump($url);
        $response = file_get_contents($url);
        $decks = NULL;
        $marvel_deck = NULL;
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
              $marvel_deck->save();
              $iterator++;
            }
          }
        }
        if ($break) {
          break;
        }
      }
      dump('Decks added: ' . $iterator . 'for card:' . $j . ' in a total of:' . $i . 'loops.');
    }
  }

  /**
   * Function to get top decks from untapped
   */
  public function getTopDecks() {

    $url = "https://api.snap.untapped.gg/api/v1/analytics/query/decks_stats_by_pool_free?TimestampRangeFilter=EXACTLY_LAST_30_DAYS_NO_CURRENT_LOCATION";
    dump($url);
    $response = file_get_contents($url);
    $decks = NULL;
    $marvel_deck = NULL;
    if (http_response_code() == 200) {
      // Request was successful.
      $decks = json_decode($response, TRUE);
      $filtered = array_filter($decks['data'], function($item) {
        return isset($item['POOL3']['ALL']['num_games']) && $item['POOL3']['ALL']['num_games'] >= 1000;
      });
      foreach ($filtered as $deck) {  
        $data_to_encode = [
          'Cards' => $deck['card_def_ids'], 
          'Name' => $deck['name'],
        ];

        $code = base64_encode(json_encode($data_to_encode));

        $query = $this->entityTypeManager()->getStorage('marvel_deck')
          ->getQuery()
          ->accessCheck()
          ->condition('did', $deck['POOL3']['arch_id']);
        $uids = $query->execute();
        $current_deck = $this->entityTypeManager()->getStorage('marvel_deck')
          ->loadMultiple($uids);
        if (empty($current_deck)) {
          /** @var \Drupal\marvel_deck\Entity\MarvelDeck $marvel_deck */
          $marvel_deck = $this->entityTypeManager()->getStorage('marvel_deck')->create([]);
          $marvel_deck->setDid($deck['POOL3']['arch_id'] ?: strval(mt_rand(100000, 999999)));
          // $marvel_deck->setAuthor($user);
          $marvel_deck->setAuthorName('admin');
          // $marvel_deck->setUid($deck['deck']['info']['uuid']);
          $name = trim(preg_replace('/[^a-zA-Z0-9?!., ]/', '', $deck['name']));
          $marvel_deck->setName($name ?: 'Unnamed');
          $marvel_deck->setUrl('');

          // $marvel_deck->setDescription($deck['deck']['info']['description']);
          $total_cost = 0;
          $total_power = 0;
          foreach ($deck['card_def_ids'] as $key => $name) {
            $query = $this->entityTypeManager()->getStorage('marvel_card')
              ->getQuery()
              ->accessCheck()
              ->condition('carddefid', $name);
            $uids = $query->execute();
            /** @var \Drupal\marvel_card\Entity\MarvelCard */
            $current_card = $this->entityTypeManager()->getStorage('marvel_card')
              ->loadMultiple($uids);
            $marvel_deck->setCard(reset($current_card));
            // dump($current_card);
            $cost = (int) reset($current_card)->get('cost')->value;
            $power = (int) reset($current_card)->get('power')->value;
            $total_cost = $total_cost + $cost;
            $total_power = $total_cost +$power;
          }
          $marvel_deck->setAvgCost($total_cost/12);
          $marvel_deck->setAvgPower($total_power/12);
          $marvel_deck->setCode($code);
          $marvel_deck->setSlug((int) $deck['POOL3']['ALL']['num_games']);
          // $marvel_deck->setChart($deck['deck']['info']['chart']);
          $marvel_deck->save();
        }
      }  
  }
  
}

  /**
   * Function to get top decks from untapped
   */
  public function getTopDecksPro() {

    $url = 'https://marvelsnap.pro/snap/do.php?cmd=getdecks';
    for ($i=1; $i < 20; $i++) { 

    $data = array(
        'cmd' => 'getdecks',
        'page' => $i,
        'limit' => 50,
        'srt' => 'publicwinloss',
        'direct' => 'desc',
        'type' => '',
        'my' => 0,
        'myarchive' => 0,
        'fav' => 0,
        'getdecks' => array(
            'hascrd' => array(),
            'youtube' => 0,
            'archetype' => 0,
            'supertype' => '',
            'smartsrch' => '',
            'pool' => 0,
            'date' => '30',
            'collection' => ''
        )
    );
    
    $options = array(
        'http' => array(
            'header' => "Content-type: application/json",
            'method' => 'POST',
            'content' => json_encode($data)
        )
    );
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);
    dump($response);

    $decks = NULL;
    $marvel_deck = NULL;
    if (http_response_code() == 200) {
      // Request was successful.
      $decks = $response;

      foreach ($decks as $deck) {  
        // $cards_to_encode = [];
        // foreach ($deck['deck'] as $card) {
        //   $cards_to_encode[] = ['CardDefId' => $card];
        // }
        // $data_to_encode = [
        //   'Cards' => $cards_to_encode, 
        //   'Name' => $deck['name'],
        // ];

        $code = $deck['code'];

        $query = $this->entityTypeManager()->getStorage('marvel_deck')
          ->getQuery()
          ->accessCheck()
          ->condition('did',  $this->hexToDec($deck['fingerprint'], 8));
        $uids = $query->execute();
        $current_deck = $this->entityTypeManager()->getStorage('marvel_deck')
          ->loadMultiple($uids);
        if (empty($current_deck)) {
          /** @var \Drupal\marvel_deck\Entity\MarvelDeck $marvel_deck */
          $marvel_deck = $this->entityTypeManager()->getStorage('marvel_deck')->create([]);
          $marvel_deck->setDid($this->hexToDec($deck['fingerprint'], 8));
          // $marvel_deck->setAuthor($user);
          $marvel_deck->setAuthorName('admin');
          // $marvel_deck->setUid($deck['deck']['info']['uuid']);
          $name = trim(preg_replace('/[^a-zA-Z0-9?!., ]/', '', $deck['humanname']));
          $marvel_deck->setName($name ?: 'Unnamed');
          $marvel_deck->setUrl('');

          // $marvel_deck->setDescription($deck['deck']['info']['description']);
          $total_cost = 0;
          $total_power = 0;
          foreach ($deck['deck'] as $key => $name) {
            $query = $this->entityTypeManager()->getStorage('marvel_card')
              ->getQuery()
              ->accessCheck()
              ->condition('carddefid', $name);
            $uids = $query->execute();
            /** @var \Drupal\marvel_card\Entity\MarvelCard */
            $current_card = $this->entityTypeManager()->getStorage('marvel_card')
              ->loadMultiple($uids);
            $marvel_deck->setCard(reset($current_card));
            // dump($current_card);
            $cost = (int) reset($current_card)->get('cost')->value;
            $power = (int) reset($current_card)->get('power')->value;
            $total_cost = $total_cost + $cost;
            $total_power = $total_cost +$power;
          }
          $marvel_deck->setAvgCost($total_cost/12);
          $marvel_deck->setAvgPower($total_power/12);
          $marvel_deck->setCode($code);
          $marvel_deck->setSlug((int)$deck['public_wins'] + (int)$deck['public_loss']);
          $marvel_deck->setLastUp((int)$deck['public_wins']);
          // $marvel_deck->setChart($deck['deck']['info']['chart']);
          $marvel_deck->save();
        }
      }  
  }
  
}
  }
function hexToDec($hex, $maxDigits) {
  $dec = 0;
  $len = strlen($hex);
  for ($i = 0; $i < $len; $i++) {
    $dec = bcadd($dec, bcmul(hexdec($hex[$i]), bcpow(16, $len - $i - 1)));
  }
  $max = bcpow(10, $maxDigits);
  $dec = bcmod($dec, $max);
  return $dec;
}
}
