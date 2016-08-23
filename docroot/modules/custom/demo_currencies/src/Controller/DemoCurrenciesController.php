<?php
/**
 * Demo currencies controller.
 */

namespace Drupal\demo_currencies\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\demo_currencies\NBRBCurrencies;

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
    if ($ids) {
      return CurrencyRate::load(current($nids));
    }
    $hader = ['Char Code', 'Name', 'Rate'];
    $rows = [];
    foreach ($ids as $id) {
      $rate = CurrencyRate::load($id);
      $rows[] = [$rate->code, $rate->name, $rate->rate];
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
