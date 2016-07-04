<?php
/**
 * @file
 * Implementation of Drupal\demo_currencies\NBRBCurrencies Service.
 */

namespace Drupal\demo_currencies;

use GuzzleHttp\ClientInterface;

class NBRBCurrencies {
  
  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;
  
  protected $url;

  protected $baseUrl;
  
  /**
   * Constructs a NBRBCurrencies object.
   * 
   * @param \GuzzleHttp\ClientInterface $http_client
   *  The HTTP Client.
   */
  public function __construct(ClientInterface $http_client, $baseUrl) {
    $this->httpClient = $http_client;
  }
  
}

