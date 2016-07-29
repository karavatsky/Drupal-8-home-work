<?php

namespace Drupal\demo_currencies\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\demo_currencies\CurencyInterface;

/**
 * Defines the Curency entity.
 *
 * @ConfigEntityType(
 *   id = "curency",
 *   label = @Translation("Curency"),
 *   handlers = {
 *     "list_builder" = "Drupal\demo_currencies\CurencyListBuilder",
 *     "form" = {
 *       "add" = "Drupal\demo_currencies\Form\CurencyForm",
 *       "edit" = "Drupal\demo_currencies\Form\CurencyForm",
 *       "delete" = "Drupal\demo_currencies\Form\CurencyDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\demo_currencies\CurencyHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "curency",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "code" = "code",
 *     "name" = "label",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/curency/{curency}",
 *     "add-form" = "/admin/structure/curency/add",
 *     "edit-form" = "/admin/structure/curency/{curency}/edit",
 *     "delete-form" = "/admin/structure/curency/{curency}/delete",
 *     "collection" = "/admin/structure/curency"
 *   }
 * )
 */
class Curency extends ConfigEntityBase implements CurencyInterface {
  /**
   * The Curency Code.
   *
   * @var string
   */
  protected $code;

  /**
   * The Curency name.
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
  public function getCode() {
    return $this->code;
  }

  /**
   * {@inheritdoc}
   */
  public function getOnPageOpt() {
    return $this->display_on_page;
  }l

  /**
   * {@inheritdoc}
   */
  public function getInBlockOpt() {
    return $this->display_in_block;
  }
}
