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

  protected $currenciesListUrl;

  protected $baseUrl;

  protected $date;

  protected $dataCurrenciesRate;

  protected $dataCurrenciesList;
  
  /**
   * Constructs a NBRBCurrencies object.
   * 
   * @param \GuzzleHttp\ClientInterface $http_client
   *  The HTTP Client.
   */
  public function __construct(ClientInterface $http_client, $base_url, $currencies_list_url) {
    $this->httpClient = $http_client;
    $this->baseUrl = $base_url;
    $this->currenciesListUrl = $currencies_list_url;
  }

  public function getCurrenciesRateData() {
    $xml = $this->getXml();
    return $this->parseXml($xml);
  }

  public function getCurrenciesListData() {
    $xml = $this->getCurrenciesXml();
    return $this->parseCurrenciesXml($xml);
  }
  
  public function setDate($date) {
    $this->date = $date;
  }

  /**
   * Get date of currencies rates as xml.
   *
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
   * Get date of currencies list as xml.
   *
   * @return string
   */
  protected function getCurrenciesXml() {
    try {
      $data = (string) $this->httpClient
        ->get($this->currenciesListUrl)
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
    $this->dataCurrenciesRate = $data;
    return $data;
  }

  protected function parseCurrenciesXml($raw_xml) {
    try {
      $xml = new \SimpleXMLElement($raw_xml);
    }
    catch (\Exception $e) {
      // SimpleXMLElement::__construct produces an E_WARNING error message for
      // each error found in the XML data and throws an exception if errors
      // were detected. Catch any exception and return failure (NULL).
      return NULL;
    }
    $result = $xml->xpath('//Currency ');
    if (!empty($result)) {
      foreach ($result as $currency) {
        $a = $currency;
      }
    }
    $data = array();
    $this->dataCurrenciesList = $data;
    return $data;
  }
}

