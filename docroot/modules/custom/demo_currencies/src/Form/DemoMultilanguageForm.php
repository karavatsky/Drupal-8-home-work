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
      '#type' => 'file',
      '#title' => $this->t('Add photo'),
      '#upload_location' => 'public://upload/demo_multilanguage/photo',
      '#upload_validators'  => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size' => array(1048576),
      ),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
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
    $destination = 'public://upload/demo_multilanguage/photo';
    file_prepare_directory($destination, FILE_CREATE_DIRECTORY);
    $validators = $form['add_photo']['#upload_validators'];
    $file = file_save_upload('add_photo', $validators, $destination, 0);
    $file->setFilename('another_name.png');
    $destination .= '/' . 'another_name.png';
    if ($file = file_move($file, $destination)) {
      $form_state->setValue('add_photo', $file);
    }
    if ($file) {
      $form_state->setValue('file_test_upload', $file);
      drupal_set_message(t('File @filepath was uploaded.', array('@filepath' => $file->getFileUri())));
      drupal_set_message(t('File name is @filename.', array('@filename' => $file->getFilename())));
      drupal_set_message(t('File MIME type is @mimetype.', array('@mimetype' => $file->getMimeType())));
      drupal_set_message(t('You WIN!'));
    }
    elseif ($file === FALSE) {
      drupal_set_message(t('Epic upload FAIL!'), 'error');
    }
//    foreach ($form_state->getValues() as $key => $value) {
//        drupal_set_message($key . ': ' . $value);
//    }

  }

}
