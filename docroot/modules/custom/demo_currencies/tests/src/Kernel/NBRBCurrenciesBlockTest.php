<?php

namespace Drupal\Tests\demo_currencies\Unit;

//use Drupal\Core\Block\BlockBase;
use Drupal\demo_currencies\Entity\CurrencyRate;
use Drupal\demo_currencies\Entity\Currency;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Demonstrates how to write tests.
 *
 * @group test_example
 */
class NBRBCurrenciesBlockTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array(
    'system',
    'block',
    'demo_currencies',
    'user',
    'datetime',
  );

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('currency');
    $this->installEntitySchema('currency_rate');
  }

  /**
   * Tests valid empty block.
   */
  public function testIsValidEmptyBlock() {
    $manager = $this->container->get('plugin.manager.block');
    $plugin_id = 'demo_currencies_currencies_block';
    $configureation = [
      'id' => $plugin_id,
      'label' => 'Currencies',
      'provider' => 'demo_currencies',
      'label_display' => 'visible',
    ];
    $display_block = $manager->createInstance($plugin_id, $configureation);
    $build = $display_block->build();
    $this->assertTrue(empty($build), 'Block is not empty.');
  }

  /**
   * Tests valid filled block.
   */
  public function testIsValidFilledBlock() {
    $manager = $this->container->get('plugin.manager.block');
    $plugin_id = 'demo_currencies_currencies_block';
    $configureation = [
      'id' => $plugin_id,
      'label' => 'Currencies',
      'provider' => 'demo_currencies',
      'label_display' => 'visible',
    ];
    $currency = Currency::Create([
      'code' => 'USD',
      'name' => 'Dollar USD',
      'display_on_page' => TRUE,
      'display_in_block' => TRUE,
    ]);
    $currency->save();
    $currency = Currency::Create([
      'code' => 'EUR',
      'name' => 'Euro',
      'display_on_page' => TRUE,
      'display_in_block' => TRUE,
    ]);
    $currency->save();

    $datetime = new DrupalDateTime();
    $date = $datetime->format('Y-m-d');

    $rate = CurrencyRate::Create([
      'code' => 'USD',
      'name' => 'Dollar USD' . ' - ' . $date,
      'date' => $date,
      'rate' => 2,
      'prev_day_diff' => 0,
    ]);
    $rate->save();

    $rate = CurrencyRate::Create([
      'code' => 'EUR',
      'name' => 'Euro' . ' - ' . $date,
      'date' => $date,
      'rate' => 2.2,
      'prev_day_diff' => 0,
    ]);
    $rate->save();

    $display_block = $manager->createInstance($plugin_id, $configureation);
    $build = $display_block->build();
    $this->assertFalse(empty($build['list']['#items']), 'Data is empty and won\'t be showed in block.');
  }
}
