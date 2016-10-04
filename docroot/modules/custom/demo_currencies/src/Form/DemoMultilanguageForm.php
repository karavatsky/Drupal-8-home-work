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
//      '#element_validate' => array(
//        array($this, 'addPhotoElementValidate'),
//      ),
//      '#value_callback' => array(
//        array($this, 'addPhotoValueCallback'),
//      ),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    ];

    return $form;
  }

//  public function addPhotoElementValidate() {
//    $args = func_get_args();
//  }

  public function addPhotoValueCallback() {
    $args = func_get_args();
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
l    parent::validateForm($form, $form_state);
    $_FILES['files']['name']['add_photo'] = 'dfdfdf.png';
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
