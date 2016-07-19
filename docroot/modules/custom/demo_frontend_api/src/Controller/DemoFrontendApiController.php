<?php

namespace Drupal\demo_frontend_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Zend\Diactoros\Response\HtmlResponse;
/**
 * Class DemoFrontendApiController.
 *
 * @package Drupal\demo_frontend_api\Controller
 */
class DemoFrontendApiController extends ControllerBase {

  /**
   * Get elements.
   *
   * @return string
   *
   */
  public function getElements($name) {

    $build['test_container'] = [
      '#type' => 'container',
      '#attributes' => array(
        'class' => 'test_container',
      ),
    ];
    $build['test_container']['test_markup'] = [
      '#type' => 'markup',
      '#markup' => $this->t(
        'Implement method: getElements with parameter(s): $name - @name',
        ['@name' => $name]
      ),
    ];

    $build['test_details'] = array(
      '#type' => 'details',
      '#title' => $this->t('Details'),
    );

    $build['test_details']['test_markup'] = [
      '#type' => 'markup',
      '#markup' => $this->t(
        'Author name - @name',
        ['@name' => $name]
      ),
    ];

    $build['test_theme'] = array(
      '#theme' => 'demo_frontend_api_theme',
      '#title' => 'title text',
      '#body' => 'Body text',
    );

    $build['test_demo_element'] = [
      '#type' => 'demo_element',
      '#label' => $this->t('Example Label'),
      '#description' => $this->t('This is the description text.'),
    ];

    return $build;
  }

  /**
   * Returns test response.
   */
  public function testResponse() {
    return new Response('Test response text.');
  }

  /**
   * Returns test HTML response.
   */
  public function testHTMLResponse() {
    return new HtmlResponse('<div>Test HTML response text.</div>');
  }
}
