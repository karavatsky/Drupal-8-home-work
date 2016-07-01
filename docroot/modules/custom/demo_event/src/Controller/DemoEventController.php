<?php
/**
 * Demo event controller.
 */

namespace Drupal\demo_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\demo_event\DemoEvent;
use Drupal\demo_event\DemoEvents;
class DemoEventController extends ControllerBase {
  public function getDemoEventPage() {
    $message_text = 'Hello everybody!';
    $dispatcher = \Drupal::service('event_dispatcher');
    $e = new DemoEvent($message_text);
    $event = $dispatcher->dispatch(DemoEvents::DEFAULT_DEMO_EVENT, $e);
    $message_text = $event->getMessage();
    drupal_set_message($message_text);
    
    $output = array();
    $output['#title'] = 'Demo event page.';
    $output['#markup'] = 'Just text';
    return $output;
  }
}
