<?php
/**
 * Demo currencies controller.
 */

namespace Drupal\demo_currencies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\demo_currencies\Entity\Currency;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\demo_currencies\NBRBCurrencies;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\demo_currencies\Entity\CurrencyRate;

class DemoCurrenciesController extends ControllerBase {

  /**
   * Constructs a \Drupal\aggregator\Controller\AggregatorController object.
   *
   * @param \Drupal\demo_currencies\NBRBCurrencies $nbrb_currencies
   *    Currencies service.
   */
  public function __construct(NBRBCurrencies $nbrb_currencies) {
    $this->nbrbCurrencies = $nbrb_currencies;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('demo_currencies.nbrb_currencies')
    );
  }

  public function getAllCurrencies() {
    $current_date = new DrupalDateTime();
    $date = $current_date->format('Y-m-d');
    $query = \Drupal::entityQuery('currency_rate')
      ->condition('date', $date);
    $ids = $query->execute();
    $header = ['Char Code', 'Name', 'Rate'];
    $rows = [];
    foreach ($ids as $id) {
      $rate = CurrencyRate::load($id);
      $currency = Currency::load($rate->code->value);
      if ($currency->getOnPageOpt()) {
        $rows[] = [$rate->code->value, $rate->name->value, $rate->rate->value];
      }
    }
    $build['currencies'] = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No Currencies available.'),
    );
    return $build;
  }
}
