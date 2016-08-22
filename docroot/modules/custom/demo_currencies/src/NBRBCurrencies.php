<?php
/**
 * @file
 * Implementation of Drupal\demo_currencies\NBRBCurrencies Service.
 */

namespace Drupal\demo_currencies;

use Drupal\demo_currencies\Entity\CurrencyRate;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Datetime\DrupalDateTime;

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

  protected function loadCurrenciesRateData() {
    $xml = $this->getXml();
    return $this->parseXml($xml);
  }

  public function getCurrenciesRateData() {
    if (!isset($this->dataCurrenciesRate)) {
      $this->loadCurrenciesRateData();
    }
    return $this->dataCurrenciesRate;
  }
  
  protected function loadCurrenciesListData() {
    $xml = $this->getCurrenciesXml();
    return $this->parseCurrenciesXml($xml);
  }

  public function getCurrenciesListData() {
    if (!isset($this->dataCurrenciesList)) {
      $this->loadCurrenciesListData();
    }
    return $this->dataCurrenciesList;
  }
  
  public function setDate($date) {
    $this->date = $date;
  }

  public function getDate() {
    return $this->date;
  }

  /**
   * Get date of currencies rates as xml.
   *
   * @return string
   */
  protected function getXml() {
    if (empty($this->date)) {
      $datetime = new DrupalDateTime();
      $this->date = $datetime->format('m/d/Y');
    }

    $url = $this->buildUrl();

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
    $data = array();
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
    $result = $xml->xpath('//Currency ');
    $data = array();
    if (!empty($result)) {
      foreach ($result as $currency) {
        $data[$currency->CharCode->__toString()] = (array) $currency;
      }
    }
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
    $data = array();
    if (!empty($result)) {
      foreach ($result as $currency) {
        $data[] = (array) $currency;
      }
    }
    $this->dataCurrenciesList = $data;
    return $data;
  }

  static function getCurrencyRateByDateAndCode($date, $code) {
    $query = \Drupal::entityQuery('currency_rate')
      ->condition('date', $date)
      ->condition('code', $code);
    $nids = $query->execute();
    if ($nids) {
      return CurrencyRate::load(current($nids));
    }
    return NULL;
  }
}

