<?php
/**
 * @file
 * Contains Drupal\demo_event\DemoEvent.
 */

/**

 */

namespace Drupal\demo_event;

use Symfony\Component\EventDispatcher\Event;

class DemoEvent extends Event {

  protected $message_text;

  /**
   * Constructor.
   *
   * @param String $message_text
   */
  public function __construct($message_text) {
    $this->message_text = $message_text;
  }

  /**
   * Getter for the text message.
   *
   * @return String
   */
  public function getMessage() {
    return $this->message_text;
  }

  /**
   * Setter for the text message.
   *
   * @param String
   */
  public function setMessage($message_text) {
    $this->message_text = $message_text;
  }
}
