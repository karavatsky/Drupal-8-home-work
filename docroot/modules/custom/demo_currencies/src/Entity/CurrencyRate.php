<?php

namespace Drupal\demo_currencies\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\demo_currencies\CurrencyRateInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Currency rate entity.
 *
 * @ingroup demo_currencies
 *
 * @ContentEntityType(
 *   id = "currency_rate",
 *   label = @Translation("Currency rate"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\demo_currencies\CurrencyRateListBuilder",
 *     "views_data" = "Drupal\demo_currencies\Entity\CurrencyRateViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\demo_currencies\Form\CurrencyRateForm",
 *       "add" = "Drupal\demo_currencies\Form\CurrencyRateForm",
 *       "edit" = "Drupal\demo_currencies\Form\CurrencyRateForm",
 *       "delete" = "Drupal\demo_currencies\Form\CurrencyRateDeleteForm",
 *     },
 *     "access" = "Drupal\demo_currencies\CurrencyRateAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\demo_currencies\CurrencyRateHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "currency_rate",
 *   admin_permission = "administer currency rate entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/currency_rate/{currency_rate}",
 *     "add-form" = "/admin/structure/currency_rate/add",
 *     "edit-form" = "/admin/structure/currency_rate/{currency_rate}/edit",
 *     "delete-form" = "/admin/structure/currency_rate/{currency_rate}/delete",
 *     "collection" = "/admin/structure/currency_rate",
 *   },
 *   field_ui_base_route = "currency_rate.settings"
 * )
 */
class CurrencyRate extends ContentEntityBase implements CurrencyRateInterface {
  use EntityChangedTrait;
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Currency rate entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Currency rate entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Currency rate entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Currency rate entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Currency rate is published.'))
      ->setDefaultValue(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Currency rate entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code'))
      ->setDescription(t('The code of the Currency rate.'))
      ->setRequired(TRUE)
      ->setPropertyConstraints('value', ['Length' => ['max' => 3, 'min' => 3]])
      ->setSettings(array(
        'default_value' => '',
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -3,
        'settings' => array(
          'size' => 5,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Date'))
      ->setDescription(t('The date of the Currency rate.'))
      ->setRequired(TRUE)
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -2,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'datetime_default',
        'weight' => -2,
        'settings' => array(
          'size' => 5,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['rate'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Rate'))
      ->setDescription(t('The rate of the Currency.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ))
      ->setDisplayOptions('form', array(
        'weight' => -1,
        'settings' => array(
          'size' => 5,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['prev_day_diff'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Previous day difference'))
      ->setDescription(t('Difference of rate with the previous day.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ))
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
