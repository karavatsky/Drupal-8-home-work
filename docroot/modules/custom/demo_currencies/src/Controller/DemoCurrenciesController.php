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
    $data = $this->nbrbCurrencies->getCurrenciesRateData();
    $header = ['Num Code', 'Char Code', 'Name', 'Rate'];
    $rows = [];
    foreach ($data as $item) {
      $rows[] = [$item['NumCode'], $item['CharCode'], $item['Name'], $item['Rate']];
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
