<?php

namespace Drupal\demo_currencies\Plugin\QueueWorker;

/**
 * Currencies rates worker.
 *
 * @QueueWorker(
 *   id = "demo_currencies_currencies_rate",
 *   title = @Translation("Create currencies rates entities."),
 *   cron = {"time" = 10}
 * )
 *
 * QueueWorkers are new in Drupal 8. They define a queue, which in this case
 * is identified as demo_currencies_currencies_rate and contain a process that operates on
 * all the data given to the queue.
 *
 * @see queue_example.module
 */
class CurrencyRateWorker extends CurrencyRateWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $this->createCurrencyRatesWork('CurrencyRateWorker', $data);
  }

}
