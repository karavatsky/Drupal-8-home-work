<?php

namespace Drupal\karavatski_ihar_lesson8\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Class LogAndCacheForm.
 *
 * @package Drupal\karavatski_ihar_lesson8\Form
 */
class LogAndCacheForm extends FormBase {

  /**
   * Drupal\Core\Logger\LoggerChannelFactory definition.
   *
   * @var Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $logger_factory;
  public function __construct(
    LoggerChannelFactory $logger_factory
  ) {
    $this->logger_factory = $logger_factory;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'log_and_cache_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['type_a_message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Type a message'),
      '#maxlength' => 256,
      '#size' => 64,
    );
    $form['save_message'] = array(
      '#type' => 'button',
      '#title' => $this->t('Save message in log & cache'),
    );
    $form['invalidate_cache'] = array(
      '#type' => 'button',
      '#title' => $this->t('Invalidate cache'),
    );
    $form['delete_cache'] = array(
      '#type' => 'button',
      '#title' => $this->t('Delete cache'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
