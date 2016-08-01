<?php

namespace Drupal\demo_currencies;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Currency entities.
 */
interface CurrencyInterface extends ConfigEntityInterface {
  // Add get/set methods for your configuration properties here.

  /**
   * Gets display on page option.
   *
   * @return boolean
   *   Display on page option.
   */
  public function getOnPageOpt();

  /**
   * Gets display in block option.
   *
   * @return boolean
   *   Display in block option.
   */
  public function getInBlockOpt();
}
