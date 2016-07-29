<?php

namespace Drupal\demo_currencies;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Curency entities.
 */
interface CurencyInterface extends ConfigEntityInterface {
  // Add get/set methods for your configuration properties here.

  /**
   * Gets code of the currency.
   *
   * @return string
   *   Code of the currency.
   */
  public function getCode();

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
