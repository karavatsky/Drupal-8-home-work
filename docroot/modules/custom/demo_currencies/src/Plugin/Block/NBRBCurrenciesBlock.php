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
  public function build() {
    $this->nbrbCurrencies->setDate('01/03/2014');
    $data = $this->nbrbCurrencies->getCurrenciesRateData();
    return [
      '#type' => 'markup',
      '#markup' => '<b>Returned by Service: </b>',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $data = $this->nbrbCurrencies->getCurrenciesListData();
    $options = array();
    foreach ($data as $currency) {
      $options[$currency['CharCode']] = $currency['Name'];  
    }
    $form['currencies'] = array(
      '#type' => 'checkboxes',
      '#options' => $options,
      '#title' => $this->t('Currencies for display'),
      '#default_value' => $this->configuration['currencies'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['currencies'] = $form_state->getValue('currencies');
  }
}
