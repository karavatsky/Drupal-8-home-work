<?php

namespace Drupal\demo_currencies\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\demo_currencies\CurrencyInterface;

/**
 * Defines the Currency entity.
 *
 * @ConfigEntityType(
 *   id = "currency",
 *   label = @Translation("Currency"),
 *   handlers = {
 *     "list_builder" = "Drupal\demo_currencies\CurrencyListBuilder",
 *     "form" = {
 *       "add" = "Drupal\demo_currencies\Form\CurrencyForm",
 *       "edit" = "Drupal\demo_currencies\Form\CurrencyForm",
 *       "delete" = "Drupal\demo_currencies\Form\CurrencyDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\demo_currencies\CurrencyHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "currency",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "code" = "id",
 *     "name" = "label",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/currency/{currency}",
 *     "add-form" = "/admin/structure/currency/add",
 *     "edit-form" = "/admin/structure/currency/{currency}/edit",
 *     "delete-form" = "/admin/structure/currency/{currency}/delete",
 *     "collection" = "/admin/structure/currency"
 *   }
 * )
 */
class Currency extends ConfigEntityBase implements CurrencyInterface {
  /**
   * The Currency Code.
   *
   * @var string
   */
  protected $code;

  /**
   * The Currency name.
   *
   * @var string
   */
  protected $label;

  /**
   * Define displaying on currency page.
   *
   * @var bool
   */
  protected $display_on_page;

  /**
   * Define displaying in currency block.
   *
   * @var bool
   */
  protected $display_in_block;

  /**
   * {@inheritdoc}
   */
  public function getOnPageOpt() {
    return $this->display_on_page;
  }

  /**
   * {@inheritdoc}
   */
  public function getInBlockOpt() {
    return $this->display_in_block;
  }
}
