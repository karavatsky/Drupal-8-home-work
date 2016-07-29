<?php

namespace Drupal\demo_currencies\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CurencyForm.
 *
 * @package Drupal\demo_currencies\Form
 */
class CurencyForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $curency = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => $curency->label(),
      '#description' => $this->t("Label for the Curency."),
      '#required' => TRUE,
    );

    $form['code'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Code'),
      '#maxlength' => 255,
      '#default_value' => $curency->code(),
      '#description' => $this->t("Code of the Curency."),
      '#required' => TRUE,
    );

    $form['display_on_page'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display on page'),
      '#default_value' => $curency->code(),
    );

    $form['display_on_page'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Display on page'),
      '#default_value' => $curency->code(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $curency = $this->entity;
    $status = $curency->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Curency.', [
          '%label' => $curency->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Curency.', [
          '%label' => $curency->label(),
        ]));
    }
    $form_state->setRedirectUrl($curency->urlInfo('collection'));
  }

}
