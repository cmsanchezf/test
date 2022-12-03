<?php

namespace Drupal\drupal_api\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Class DrupalAPIClient, provide a calls to drupal.org API.
 *
 * @package Drupal\drupal_api\Services
 */
class DrupalAPIClient {

  private const API_URL = 'https://www.drupal.org/api-d7/';

  /**
   * DrupalAPIClient constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(private ClientInterface $httpClient, private LoggerChannelFactoryInterface $loggerFactory, private ConfigFactoryInterface $configFactory) {
  }

  /**
   * Get data from a module with a given name.
   */
  public function getModuleData(String $name) {
    $logger = $this->loggerFactory->get('drupal_api');
    try {
      $response = $this->httpClient->request('GET', self::API_URL . 'node.json?field_project_machine_name=' . $name);
      $list = json_decode($response->getBody()->getContents())->list;
      if ($response->getStatusCode() != '200' || empty($list)) {
        throw new \Exception('Not found project in drupal.org.');
      }
      $logger->info('Request was successful');
    }
    catch (\Exception $e) {
      $response = null;
      $logger->error('Error: @message', ['@message' => $e->getMessage()]);
    }
    return $response;
  }

  /**
   * Get data from a module with a given name.
   */
  public function getTopIssues() {
    $logger = $this->loggerFactory->get('drupal_api');
    $nid = $this->configFactory->getEditable('drupal_api_config.settings')->get('project_nid');
    try {
      $response = $this->http_client->request('GET', self::API_URL . 'node.json?type=project_issue&field_issue_status=1&field_project='.$nid);
      if ($response->getStatusCode() != '200') {
        throw new \Exception('There was an error obtaining data from drupal.org.');
      }
      $logger->info('Request was successful');
    }
    catch (\Exception $e) {
      $response = null;
      $logger->error('Error: @message', ['@message' => $e->getMessage()]);
    }
      return $response;
  }

}
