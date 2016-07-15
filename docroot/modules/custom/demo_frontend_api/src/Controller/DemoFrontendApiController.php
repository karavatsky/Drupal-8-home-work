<?php

namespace Drupal\demo_frontend_api\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DemoFrontendApiController.
 *
 * @package Drupal\demo_frontend_api\Controller
 */
class DemoFrontendApiController extends ControllerBase {

  /**
   * Get elements.
   *
   * @return string
   *
   */
  public function getElements($name) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: getElements with parameter(s): $name'),
    ];
  }

}
