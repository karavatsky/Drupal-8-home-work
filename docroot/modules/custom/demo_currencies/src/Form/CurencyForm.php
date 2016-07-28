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
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $curency->label(),
      '#description' => $this->t("Label for the Curency."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $curency->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\demo_currencies\Entity\Curency::load',
      ),
      '#disabled' => !$curency->isNew(),
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
