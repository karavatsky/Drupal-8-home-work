<?php
namespace Drupal\testmodule\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Example functional test.
 * @group testmodule
 */
class FruitFormTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  static public $modules = array(
    'simpletest_example',
    'simpletest_example_test',
    'testmodule',
  );

  /**
   * Sets the test up.
   */
  protected function setUp() {
    parent::setUp();
  }

  public function testFruitForm() {

    // Create a user.
    $test_user = $this->drupalCreateUser(array('access content'));

    // Log them in.
    $this->drupalLogin($test_user);

    $this->drupalGet('testmodule/form');
    $this->assertResponse('200');

    $this->assertFieldById('edit-submit', '', 'The form has submit button.');
    $this->assertFieldByName('email_address', NULL, 'The form has email address field.');

    $this->drupalPostForm(NULL, array(
      'email_address' => 'test@gmail.com',
      'favorite_fruit' => 'Apple',
    ), t('Submit!'));
    $this->assertText('Apple! Wow! Nice choice! Thanks for telling us!', 'The email validation passed.');

    $this->drupalPostForm('testmodule/form', array(
      'email_address' => 'test@tut.by',
      'favorite_fruit' => 'Apple',
    ), t('Submit!'));
    $this->assertText('Sorry, we only accept Gmail or Yahoo email addresses at this time.', 'The email validation did not passed.');
  }
}
