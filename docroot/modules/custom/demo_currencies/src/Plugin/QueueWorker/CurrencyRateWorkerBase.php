<?php

namespace Drupal\demo_currencies\Plugin\QueueWorker;

use Drupal\Core\State\StateInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\demo_currencies\NBRBCurrencies;
use Drupal\demo_currencies\Entity\CurrencyRate;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Provides base functionality for the CurrencyRateWorker.
 */
abstract class CurrencyRateWorkerBase extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;


  /**
   * The state.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * CurrencyRateWorkerBase constructor.
   *
   * @param array $configuration
   *   The configuration of the instance.
   * @param string $plugin_id
   *   The plugin id.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service the instance should use.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger service the instance should use.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StateInterface $state, LoggerChannelFactoryInterface $logger, NBRBCurrencies $nbrb_currencies) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->state = $state;
    $this->logger = $logger;
    $this->nbrbCurrencies = $nbrb_currencies;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('state'),
      $container->get('logger.factory'),
      $container->get('demo_currencies.nbrb_currencies')
    );
  }

  /**
   * Simple reporter log and display information about the queue.
   *
   * @param int $worker
   *   Worker number.
   * @param object $item
   *   The $item which was stored in the cron queue.
   */
  protected function createCurrencyRatesWork($worker, $item) {
    $rate_date = new DrupalDateTime($item['date']);
    $rate_date_string = $rate_date->__toString();
    $check_currency_rate = NBRBCurrencies::getCurrencyRateByDateAndCode($item['CharCode'], $rate_date_string);
    if ($check_currency_rate) {
      return;
    }
    $rate_date->sub(new \DateInterval('P1D'));
    $day_ago_currency_rate = NBRBCurrencies::getCurrencyRateByDateAndCode($item['CharCode'], $rate_date->__toString());
    $day_ago_currency_rate->rate->value();
    $rate = CurrencyRate::Create([
      'code' => $item['CharCode'],
      'name' => $item['Name'],
      'date' => $rate_date_string,
      'display_on_page' => TRUE,
    ]);
    $rate->save();

    $this->logger->get('demo_currencies')->info(
      'Queue @worker worker processed item with sequence @currency created for @date with rate = @rate.', [
      '@worker' => $worker,
      '@currency' => $item['Name'],
      '@date' => date_iso8601($item['date']),
      '@rate' => $item['Rate'],
    ]);
  }
}
