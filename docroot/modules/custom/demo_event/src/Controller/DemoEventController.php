<?php
/**
 * Demo event controller.
 */

namespace Drupal\demo_event\Controller;
use Drupal\Core\Controller\ControllerBase;

class DemoEventController extends ControllerBase {
  public function getDemoEventPage() {
    $output = array();
    $output['#title'] = 'Demo event page.';
    $output['#markup'] = 'Just text';
    return $output;
  }
}
