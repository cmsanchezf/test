<?php

namespace Drupal\drupal_api\Services;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Cache\CacheBackendInterface;
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
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP client.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache.
   */
  public function __construct(private ClientInterface $httpClient, private LoggerChannelFactoryInterface $loggerFactory, private CacheBackendInterface $cache) {
  }

  /**
   * Get data from a module with a given name.
   */
  public function getModuleData(String $name) {
    $logger = $this->loggerFactory->get('drupal_api');
    try {
      $request = $this->httpClient->request('GET', self::API_URL . 'node.json?field_project_machine_name=' . $name);
      $list = json_decode($request->getBody()->getContents())->list;
      if ($request->getStatusCode() != '200' || empty($list)) {
        throw new \Exception('Not found project in drupal.org.');
      }
      $response = $list;
      $logger->info('Request was successful');
    }
    catch (\Exception $e) {
      $response = NULL;
      $logger->error('Error: @message', ['@message' => $e->getMessage()]);
    }
    return $response;
  }

  /**
   * Get data from a module with a given nid.
   */
  public function getTopIssues($project) {
    $logger = $this->loggerFactory->get('drupal_api');

    // Create a cache ID for the response.
    $cacheId = 'drupal_api.top_issues.' . $project;

    // Check if the response is already cached.
    $cache = $this->cache->get($cacheId);
    if ($cache) {
      return $cache->data;
    }

    try {
      $response = NULL;
      $request = $this->httpClient->request('GET', self::API_URL . 'node.json?type=project_issue&field_issue_status=1&field_project=' . $project);
      if ($request->getStatusCode() != '200') {
        throw new \Exception('There was an error obtaining data from drupal.org.');
      }
      $logger->info('Request was successful');
      $response = $request->getBody()->getContents();
      // Cache the response for 10 hours.
      $this->cache->set($cacheId, $response, time() + 36000);
    }
    catch (\Exception $e) {
      $response = NULL;
      $logger->error('Error: @message', ['@message' => $e->getMessage()]);
    }

    return $response;
  }

}
