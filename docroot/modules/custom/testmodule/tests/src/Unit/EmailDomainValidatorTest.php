<?php

namespace Drupal\Tests\testmodule\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\testmodule\Email\EmailDomainValidator;
use Drupal\testmodule\Email\EmailParser;

/**
 * Demonstrates how to write tests.
 *
 * @group test_example
 */
class EmailDomainValidatorTest extends UnitTestCase {

  private $accepted_domains = ['gmail.com', 'yahoo.com'];

  /**
   * Tests valid Email addresses.
   *
   * @dataProvider IsValidEmailsDataProvider
   */
  public function testIsValidEmails($email_address) {
    $domainValidator = new EmailDomainValidator(new EmailParser());
    $result =  $domainValidator->validate($email_address, $this->accepted_domains);
    $this->assertTrue($result, $email_address.' is a valid Email.');
  }
  /**
   * Tests invalid Email addresses..
   *
   * @dataProvider IsInvalidEmailsDataProvider
   */
  public function testIsInvalidEmails($email_address) {
    $domainValidator = new EmailDomainValidator(new EmailParser());
    $result =  $domainValidator->validate($email_address, $this->accepted_domains);
    $this->assertFalse($result, $email_address.' is a valid Email.');
  }

  public function IsValidEmailsDataProvider() {
    return [
      ['test@yahoo.com'],
      ['test@gmail.com'],
    ];
  }

  public function IsInvalidEmailsDataProvider() {
    return [
      ['test@tut.by'],
      ['test@mail.ru'],
      ['test@my.com'],
    ];
  }
}
