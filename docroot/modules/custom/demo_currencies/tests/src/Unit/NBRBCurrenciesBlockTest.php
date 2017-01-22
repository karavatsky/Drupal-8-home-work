<?php

namespace Drupal\Tests\demo_currencies\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\Block\BlockBase;
use Drupal\Component\Plugin\PluginManagerBase;

/**
 * Demonstrates how to write tests.
 *
 * @group test_example
 */
class NBRBCurrenciesBlockTest extends UnitTestCase {

  private $NBRBCurrenciesBlock;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $plugin_id = 'demo_currencies_currencies_block';
    $configureation = [
      'id' => $plugin_id,
      'label' => 'Currencies',
      'provider' => 'demo_currencies',
      'label_display' => 'visible',
    ];
    $this->NBRBCurrenciesBlock = PluginManagerBase::createInstance($plugin_id, $configureation);
  }
}
