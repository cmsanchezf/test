<?php

namespace Drupal\marvel_card\Controller;

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Controller\ControllerBase;

/**
 * This controller is for the routes of the races of the project.
 */
class AddCardsController extends ControllerBase {

  /**
   *
   */
  public function add() {
    $url = 'https://marvelsnapzone.com/getinfo/?searchtype=cards&searchcardstype=true';
    $response = file_get_contents($url);
    $data = NULL;
    $image = NULL;
    $file = NULL;
    if (http_response_code() == 200) {
        // Request was successful.
        $data = json_decode($response, TRUE)['success']['cards'];
        foreach ($data as $value) {
            $image_url = $value['art'];
            $image_data = file_get_contents($image_url);
            $file_name = basename($image_url);
            $file = File::create([
                'uri' => 'public://' . $file_name,
            ]);
            $file->setFileUri('public://' . $file_name);
            $file->setFilename($file_name);
            $file->setMimeType(mime_content_type('public://' . $file_name));
            $file->setSize(strlen($image_data));
            $saved = $file->save();
             // Save the file to a field of the media type.
             if($saved){
            $media = Media::create([
                'bundle' => 'image',
                'field_media_image' => [
                'target_id' => $file->id(),
                ],
            ]);
            $media->save();
        }
                    }
    }else {
      // Request was not successful
      // handle the error.
    }
  }

}
