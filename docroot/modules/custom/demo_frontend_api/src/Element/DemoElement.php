<?php
/**
 * @file
 * Contains \Drupal\demo_frontend_api\Element\DemoElement.
 */

namespace Drupal\demo_frontend_api\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Url;
/**
 * Provides an example element.
 *
 * @RenderElement("demo_element")
 */
class DemoElement extends RenderElement {
  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#theme' => 'demo_element',
      '#label' => 'Default Label',
      '#description' => 'Default Description',
      '#pre_render' => [
        [$class, 'preRenderDemoElement'],
      ],
    ];
  }

  /**
   * Prepare the render array for the template.
   */
  public static function preRenderDemoElement($element) {
    // Create a link render array using our #label.
    $element['link'] = [
      '#type' => 'link',
      '#title' => $element['#label'],
      '#url' => Url::fromUri('http://www.drupal.org'),
    ];

    // Create a description render array using #description.
    $element['description'] = [
      '#markup' => $element['#description']
    ];

    $element['pre_render_addition'] = [
      '#markup' => 'Additional text.'
    ];

    // Create a variable.
    $element['#random_number'] = rand(0,100);

    return $element;
  }
}
