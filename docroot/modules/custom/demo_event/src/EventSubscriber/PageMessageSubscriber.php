<?php
/**
 * @file
 * Contains Drupal\demo_event\EventSubscriber\PageMessageSubscriber.
 */

namespace Drupal\demo_event\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\demo_event\DemoEvents;
use Drupal\demo_event\DemoEvent;

class PageMessageSubscriber implements EventSubscriberInterface{
  protected $currentUser;

  public function __construct($currentUser) {
    $this->currentUser = $currentUser;
  }

  public static function getSubscribedEvents() {
    $events[DemoEvents::DEFAULT_DEMO_EVENT][] = array('messageChange', 0);
    return $events;
  }
  
  public function messageChange(DemoEvent $event) {
    $message = 'Hello ' . $this->current_user->getUsername() . '!';
    $event->setMessage($message);
  }
}
