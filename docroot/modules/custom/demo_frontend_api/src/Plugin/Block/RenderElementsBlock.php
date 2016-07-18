<?php

namespace Drupal\demo_frontend_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'RenderElementsBlock' block.
 *
 * @Block(
 *  id = "render_elements_block",
 *  admin_label = @Translation("Render elements block"),
 * )
 */
class RenderElementsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $build['#cache']['max-age'] = 0;

    $build['render_elements_block']['#markup'] = 'Implement RenderElementsBlock.';

    $build['test_dropbutton'] = array(
      '#type' => 'dropbutton',
      '#links' => array(
        'simple_form' => array(
          'title' => $this->t('Simple Form'),
          'url' => Url::fromRoute('block.admin_display'),
        ),
        'demo' => array(
          'title' => $this->t('Build Demo'),
          'url' => Url::fromRoute('filter.tips_all'),
        ),
      ),
    );

    $build['test_html_tag'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('Hello World'),
    ];

//    $build['test_placeholders'] = [
//      '#attached' => ['placeholders' => ['@plchldr' => 'World']],
//      '#markup' => ['Hello @plchldr'],
//    ];

//    $build['my_element'] = [
//     '#attached' => ['placeholders' => ['@foo' => 'replacement']],
//     '#markup' => ['Something about @foo'],
//    ];

    return $build;
  }

}
