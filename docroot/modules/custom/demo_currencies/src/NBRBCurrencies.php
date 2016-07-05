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

  protected $date;

  protected $data;
  
  /**
   * Constructs a NBRBCurrencies object.
   * 
   * @param \GuzzleHttp\ClientInterface $http_client
   *  The HTTP Client.
   */
  public function __construct(ClientInterface $http_client, $baseUrl) {
    $this->httpClient = $http_client;
    $this->baseUrl = $baseUrl;
  }

  public function getData() {
    $xml = $this->getXml();
    return $this->parseXml($xml);
  }

  public function setDate($date) {
    $this->date = $date;
  }

  /**
   * Get date of currencies as xml.
   * 
   * @param $date
   * @return string
   */
  protected function getXml() {
    $url = $this->buildUrl($this->date);
    $data = '';
    try {
      $data = (string) $this->httpClient
        ->get($url)
        ->getBody();
    } catch (RequestException $exception) {
      watchdog_exception('update', $exception);
    }
    return $data;
  }


  /**
   * Generate URL to fetch information about currencies.
   * 
   * @param $date
   *  Format - m/d/Y .
   * @return string
   *   The URL for fetching information about currencies.
   */
  protected function buildUrl() {
    $url = $this->baseUrl;
    if (!empty($this->date)) {
      $url = $url . '/ondate=' . $this->date;
    }
    $this->url = $url;
    return $url;
  }

  protected function parseXml($raw_xml) {
    try {
      $xml = new \SimpleXMLElement($raw_xml);
    }
    catch (\Exception $e) {
      // SimpleXMLElement::__construct produces an E_WARNING error message for
      // each error found in the XML data and throws an exception if errors
      // were detected. Catch any exception and return failure (NULL).
      return NULL;
    }
    // If there is no valid project data, the XML is invalid, so return failure.
    if (!isset($xml->short_name)) {
      return NULL;
    }
    $data = array();
    $this->data = $data;
    return $data;
  }
}

