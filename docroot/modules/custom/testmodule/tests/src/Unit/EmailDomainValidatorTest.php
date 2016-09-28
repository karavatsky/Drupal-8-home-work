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

  /**
   * Test emails with mocked parser.
   *
   * @dataProvider IsValidDomainsDataProvider
   */
  public function testIsValidEmailsMockedParser($domain) {
    $mock_email_parser = $this->getMock('Drupal\testmodule\Email\EmailParser', array('parse'));
    $this->assertInstanceOf('Drupal\testmodule\Email\EmailParserInterface', $mock_email_parser);
    $mock_email_entity = $this->getMock('Drupal\testmodule\Email', array('getDomain'));
    $this->assertInstanceOf('Drupal\testmodule\Email', $mock_email_entity);
    $mock_email_entity->expects($this->once())->method('getDomain')->will($this->returnValue($domain));
    $mock_email_parser->expects($this->once())->method('parse')->will($this->returnValue($mock_email_entity));
    $domainValidator = new EmailDomainValidator($mock_email_parser);
    $result =  $domainValidator->validate('test@test.test', $this->accepted_domains);
    $this->assertTrue($result, $domain.' is a valid domain.');
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

  public function IsValidDomainsDataProvider() {
    return [
      ['yahoo.com'],
      ['gmail.com'],
    ];
  }
}
