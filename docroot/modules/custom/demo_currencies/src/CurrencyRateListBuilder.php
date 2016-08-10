<?php

namespace Drupal\demo_currencies;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Currency rate entities.
 *
 * @ingroup demo_currencies
 */
class CurrencyRateListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Currency rate ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\demo_currencies\Entity\CurrencyRate */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.currency_rate.edit_form', array(
          'currency_rate' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
