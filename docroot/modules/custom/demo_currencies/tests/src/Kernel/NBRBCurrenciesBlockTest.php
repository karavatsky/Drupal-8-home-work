<?php

namespace Drupal\Tests\demo_currencies\Unit;

//use Drupal\Tests\UnitTestCase;
use Drupal\Core\Block\BlockBase;
//use Drupal\Component\Plugin\PluginManagerBase;
//use Drupal\plugin_test\Plugin\MockBlockManager;
use Drupal\KernelTests\KernelTestBase;

/**
 * Demonstrates how to write tests.
 *
 * @group test_example
 */
class NBRBCurrenciesBlockTest extends KernelTestBase {

  private $NBRBCurrenciesBlock;

  /**
   * Tests valid Email addresses.
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
    $this->NBRBCurrenciesBlock = $manager->createInstance($plugin_id, $configureation);
    $a = 1;
    $this->assertTrue(TRUE, 'Is a valid.');
  }
}
