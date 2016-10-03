<?php

namespace Drupal\demo_currencies\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DemoMultilanguageForm.
 *
 * @package Drupal\demo_currencies\Form
 */
class DemoMultilanguageForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'demo_multilanguage_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['add_photo'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Add photo'),
      '#upload_location' => 'public://upload/demo_multilanguage/photo',
      '#upload_validators'  => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size' => array(1048576),
      ),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }

  }

}
