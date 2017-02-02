<?php
/**
 * @file
 * Implementation of Drupal\demo_currencies\Plugin\Block\NBRBCurrenciesBlock  Block Plugin.
 */

namespace Drupal\demo_currencies\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\demo_currencies\NBRBCurrencies;
use Drupal\Core\Url;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\demo_currencies\Entity\CurrencyRate;
use Drupal\demo_currencies\Entity\Currency;

/**
 * Provides an Currencies block with the chosen currencies.
 *
 * @Block(
 *   id = "demo_currencies_currencies_block",
 *   admin_label = @Translation("Currencies"),
 * )
 */
class NBRBCurrenciesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * NBRBCurrencies Service.
   *
   * @var \Drupal\demo_currencies\NBRBCurrencies
   */
  protected $nbrbCurrencies;

  /**
   * Constructs an NBRBCurrenciesBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\demo_currencies\NBRBCurrencies $nbrb_currencies
   *   NBRBCurrencies Service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, NBRBCurrencies $nbrb_currencies) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
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
      $container->get('demo_currencies.nbrb_currencies')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() { //1
    $current_date = new DrupalDateTime();
    $date = $current_date->format('Y-m-d'); //2
    $query = \Drupal::entityQuery('currency_rate')
      ->condition('date', $date);
    $ids = $query->execute();
    $show_currencies = [];
    foreach ($ids as $id) {  //3
      $rate = CurrencyRate::load($id);
      $currency = Currency::load($rate->code->value); //4
      if ($currency->getInBlockOpt()) { //5
        $show_currencies[$rate->code->value] = $rate; //6
      } //7
    }
    if (!empty($show_currencies)) { //8
      // Only display the block if there are items to show.
      $build['#cache']['max-age'] = 0; //9
      $build['list'] = [
        '#theme' => 'item_list',
        '#items' => [],
      ];
      foreach ($show_currencies as $item) { //10
        if ($item) {  //11
          $build['list']['#items'][$item->code->value] = [  //12
            '#type' => 'markup',
            '#markup' => '<b>' . $item->name->value . ': </b>' . $item->rate->value,
          ];  //13
        }
      }
      $build['more_link'] = [ //14
        '#type' => 'link',
        '#title' => $this->t('View More Currencies.'),
        '#url' => Url::fromRoute('demo_currencies.all_currencies'),
      ];
      return $build;
    }
  } //15

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    return $form;
  }

}
