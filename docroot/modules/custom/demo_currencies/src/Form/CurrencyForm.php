<?php

namespace Drupal\demo_currencies\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CurrencyForm.
 *
 * @package Drupal\demo_currencies\Form
 */
class CurrencyForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $currency = $this->entity;
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => $currency->label(),
      '#description' => $this->t("Label for the Currency."),
      '#required' => TRUE,
    );

    $form['code'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Code'),
      '#maxlength' => 255,
      '#default_value' => $currency->id(),
      '#description' => $this->t("Code of the Currency."),
      '#required' => TRUE,
    );

    $form['display_on_page'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display on page'),
      '#default_value' => $currency->getOnPageOpt(),
    );

    $form['display_in_block'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display in block'),
      '#default_value' => $currency->getInBlockOpt(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $currency = $this->entity;
    $status = $currency->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Currency.', [
          '%label' => $currency->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Currency.', [
          '%label' => $currency->label(),
        ]));
    }
    $form_state->setRedirectUrl($currency->urlInfo('collection'));
  }

}
