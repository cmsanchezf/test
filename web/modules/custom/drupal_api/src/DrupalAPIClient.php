<?php

namespace Drupal\drupal_api;

use GuzzleHttp\ClientInterface;

/**
 * Class DrupalAPIClient, provide a calls to drupal.org API.
 *
 * @package Drupal\drupal_api
 */
class DrupalAPIClient {

  private const API_URL = 'https://www.drupal.org/api-d7/';

  /**
   * DrupalAPIClient constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(private ClientInterface $http_client) {
  }

  /**
   * Get data from a module with a given name.
   */
  public function getModuleData(String $name) {
    $request = $this->http_client->request('GET', self::API_URL . 'node.json?field_project_machine_name=' . $name);
    return $request;
  }

  /**
   * Get data from a module with a given name.
   */
  public function getTopIssues() {
    $request = $this->http_client->request('GET', self::API_URL . 'node.json?type=project_issue&field_issue_status=1&field_project=1234');
    return $request;
  }

}
