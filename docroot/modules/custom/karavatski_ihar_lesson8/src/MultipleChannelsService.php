<?php

namespace Drupal\karavatski_ihar_lesson8;

use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Class MultipleChannelsService.
 *
 * @package Drupal\karavatski_ihar_lesson8
 */
class MultipleChannelsService {

  /**
   * \Drupal\Core\Logger\LoggerChannelFactory definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerFactory;
  /**
   * Constructor.
   */
  public function __construct(LoggerChannelFactory $logger_factory) {
    $this->loggerFactory = $logger_factory;
  }

  public function logToOtherChannels($message) {
    $this->loggerFactory->get('mytype')->emergency($message);
    $this->loggerFactory->get('lesson8')->warning($message);
  }
}
