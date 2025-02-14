<?php

namespace Drupal\Tests\geoblock\Unit;

use Drupal\geoblock\IPAddress;

use Drupal\Tests\UnitTestCase;

/**
 * Unit tests for the IP address object.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @coversDefaultClass \Drupal\geoblock\IPAddress
 * @group geoblock
 */
class IPAddressTest extends UnitTestCase {

  /**
   * Data provider for ::testAddress().
   */
  public function providerTestAddress() {
    return [
      'invalid IPv4 address' => [
        '12.0.0.',
        FALSE,
        \InvalidArgumentException::class,
        'An invalid address was supplied; the supplied IP address must be a valid IPv4 or IPv6 address',
      ],
      'invalid IPv6 address' => [
        '2600',
        FALSE,
        \InvalidArgumentException::class,
        'An invalid address was supplied; the supplied IP address must be a valid IPv4 or IPv6 address',
      ],
      'valid, private IPv4 address' => [
        '10.0.0.1',
        FALSE,
        NULL,
        NULL,
      ],
      'valid, private IPv6 address' => [
        'fc00::1',
        FALSE,
        NULL,
        NULL,
      ],
      'valid, public IPv4 address' => [
        '8.8.8.8',
        TRUE,
        NULL,
        NULL,
      ],
      'valid, public IPv6 address' => [
        '2001:4860:4860::8888',
        TRUE,
        NULL,
        NULL,
      ],
      'valid, reserved IPv4 address' => [
        '169.254.0.1',
        FALSE,
        NULL,
        NULL,
      ],
      'valid, reserved IPv6 address' => [
        'fe80::1',
        FALSE,
        NULL,
        NULL,
      ],
    ];
  }

  /**
   * Data provider for ::testAddressCountryCodeValidation().
   */
  public function providerTestAddressCountryCodeValidation() {

    return [
      'invalid country code' => [
        'CountryCode',
        'AA',
        \InvalidArgumentException::class,
        "AA is not a valid ISO 3166-1 alpha-2 country code",
      ],
      'invalid registered country code' => [
        'RegisteredCountryCode',
        'AA',
        \InvalidArgumentException::class,
        "AA is not a valid ISO 3166-1 alpha-2 country code",
      ],
      'valid country code' => [
        'CountryCode',
        'US',
        NULL,
        NULL,
      ],
      'valid registered country code' => [
        'RegisteredCountryCode',
        'US',
        NULL,
        NULL,
      ],
    ];
  }

  /**
   * Data provider for ::testAddressDomesticUse().
   */
  public function providerTestAddressDomesticUse() {
    return [
      'domestic use' => [
        TRUE,
        'US',
        'US',
      ],
      'international use' => [
        FALSE,
        'IE',
        'US',
      ],
      'country code only' => [
        TRUE,
        'US',
        NULL,
      ],
      'registered country code only' => [
        TRUE,
        NULL,
        'US',
      ],
      'unlocated address' => [
        TRUE,
        NULL,
        NULL,
      ],
    ];
  }

  /**
   * Tests IP address construction and filtering.
   *
   * @dataProvider providerTestAddress
   *
   * @covers ::__construct
   * @covers ::getAddress
   * @covers ::isPublic
   */
  public function testAddress(string $input, bool $is_public, ?string $exception, ?string $exception_message) {
    if (isset($exception)) {
      $this->expectException($exception);

      if (isset($exception_message)) {
        $this->expectExceptionMessage($exception_message);
      }
    }

    if ($address = new IPAddress($input)) {
      $this->assertSame($input, $address->getAddress());
      $this->assertSame($is_public, $address->isPublic());
    }
  }

  /**
   * Tests country code validation.
   *
   * @dataProvider providerTestAddressCountryCodeValidation
   *
   * @covers ::getCountryCode
   * @covers ::getRegisteredCountryCode
   * @covers ::setCountryCode
   * @covers ::setRegisteredCountryCode
   * @covers ::validateCountryCode
   */
  public function testAddressCountryCodeValidation(string $type, string $country_code, ?string $exception, ?string $exception_message) {
    $address = new IPAddress('10.0.0.1');

    if (isset($exception)) {
      $this->expectException($exception);

      if (isset($exception_message)) {
        $this->expectExceptionMessage($exception_message);
      }
    }

    $get_method = "get{$type}";
    $set_method = "set{$type}";

    $address->{$set_method}($country_code);

    $expected = !isset($exception) ? $country_code : NULL;
    $this->assertSame($expected, $address->{$get_method}());
  }

  /**
   * Tests the domestic use assertion of an IP address.
   *
   * @dataProvider providerTestAddressDomesticUse
   *
   * @covers ::isDomesticUse
   */
  public function testAddressDomesticUse(bool $is_domestic_use, ?string $country_code, ?string $registered_country_code) {
    $address = new IPAddress('10.0.0.1');

    if (isset($country_code)) {
      $address->setCountryCode($country_code);
    }

    if (isset($registered_country_code)) {
      $address->setRegisteredCountryCode($registered_country_code);
    }

    $this->assertSame($country_code, $address->getCountryCode());
    $this->assertSame($registered_country_code, $address->getRegisteredCountryCode());

    $this->assertSame($is_domestic_use, $address->isDomesticUse());
  }

}
