<?php

namespace Drupal\karavatski_ihar_lesson8\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\karavatski_ihar_lesson8\MultipleChannelsService;

/**
 * Class LogAndCacheForm.
 *
 * @package Drupal\karavatski_ihar_lesson8\Form
 */
class LogAndCacheForm extends FormBase {

  const CID = 'karavatski_ihar_lesson8:message';
  /**
   * \Drupal\karavatski_ihar_lesson8\LoggerChannelFactory definition.
   *
   * @var \Drupal\karavatski_ihar_lesson8\LoggerChannelFactory
   */
  protected $logger_factory;
  public function __construct(
    MultipleChannelsService $logger_multiple_channels
  ) {
    $this->loggerMultipleChannels = $logger_multiple_channels;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('karavatski_ihar_lesson8.log_to_multiple_channels')
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
    self::showStatusMessages();
    $form['type_a_message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Type a message'),
      '#maxlength' => 256,
      '#size' => 64,
    );
    $form['save_message'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save message in log & cache'),
      '#submit' => array(array($this, 'saveMessage')),
      '#validate' => array(array($this, 'validateMessage')),
    );
    $form['invalidate_cache'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Invalidate cache'),
      '#submit' => array(array($this, 'invalidateCache')),
    );
    $form['delete_cache'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Delete cache'),
      '#submit' => array(array($this, 'deleteCache')),
    );

    return $form;
  }

  public function saveMessage($form, FormStateInterface $form_state) {
    $message = $form_state->getValue('type_a_message');
    $this->loggerMultipleChannels->logToOtherChannels($message);
    \Drupal::cache()->set(self::CID, $message);
  }

  public function invalidateCache($form, FormStateInterface $form_state) {
    \Drupal::cache()->invalidate(self::CID);
  }

  public function deleteCache($form, FormStateInterface $form_state) {
    \Drupal::cache()->delete(self::CID);
  }

  public function validateMessage($form, FormStateInterface $form_state) {
    if ($form_state->isValueEmpty(array('type_a_message'))) {
      $form_state->setErrorByName('type_a_message', t('Type a message is required.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  private static function showStatusMessages() {
    $cache_data = \Drupal::cache()->get(self::CID, TRUE);
    if ($cache_data && $cache_data->valid) {
      drupal_set_message('Cache item: ' . $cache_data->data . ' - valid.');
    }
    elseif ($cache_data && !$cache_data->valid) {
      drupal_set_message('Cache item: ' . $cache_data->data . ' - invalid.');
    }
    else {
      drupal_set_message('There are no any cache items.');
    }
    $a = 1;
  }
}
