<?php

namespace Drupal\Tests\geoblock\Unit;

use Drupal\geoblock\IPAddress;
use Drupal\geoblock\Restriction\CountryCodeRestriction;

use Drupal\Tests\UnitTestCase;

/**
 * Unit tests for the country code restriction.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @coversDefaultClass \Drupal\geoblock\Restriction\CountryCodeRestriction
 * @group geoblock
 */
class CountryCodeRestrictionTest extends UnitTestCase {

  /**
   * Data provider for ::testRestrictionApplies().
   */
  public function providerTestRestrictionApplies() {
    return [
      'has restriction country codes, allow restriction type' => [
        ['US', 'IE'],
        'allow',
        TRUE,
      ],
      'has restriction country codes, block restriction type' => [
        ['US', 'IE'],
        'block',
        TRUE,
      ],
      'has restriction country codes, invalid restriction type' => [
        ['US', 'IE'],
        'invalid',
        FALSE,
      ],
      'has restriction country codes, no restriction type' => [
        ['US', 'IE'],
        NULL,
        FALSE,
      ],
      'no restriction country codes, allow restriction type' => [
        [],
        'allow',
        FALSE,
      ],
      'no restriction country codes, block restriction type' => [
        [],
        'block',
        FALSE,
      ],
      'no restriction country codes, invalid restriction type' => [
        [],
        'invalid',
        FALSE,
      ],
      'no restriction country codes, no restriction type' => [
        [],
        NULL,
        FALSE,
      ],
    ];
  }

  /**
   * Data provider for ::testRestrictionEnforce().
   */
  public function providerTestRestrictionEnforce() {
    $united_states = new IPAddress('10.0.0.1');
    $united_states->setCountryCode('US');

    $isle_of_man = new IPAddress('10.0.0.1');
    $isle_of_man->setCountryCode('IM');

    return [
      'member address, allow restriction' => [
        $united_states,
        'allow',
        FALSE,
      ],
      'member address, block restriction' => [
        $united_states,
        'block',
        TRUE,
      ],
      'non-member address, allow restriction' => [
        $isle_of_man,
        'allow',
        TRUE,
      ],
      'non-member address, block restriction' => [
        $isle_of_man,
        'block',
        FALSE,
      ],
    ];
  }

  /**
   * Tests when the country code restriction applies.
   *
   * @dataProvider providerTestRestrictionApplies
   *
   * @covers ::__construct
   * @covers ::applies
   */
  public function testRestrictionApplies(?array $restriction_country_codes, ?string $restriction_type, bool $applies) {
    /** @var \Drupal\Core\Config\ConfigFactoryInterface */
    $config_factory = $this->getConfigFactoryStub([
      'geoblock.settings' => [
        'restriction_country_codes' => $restriction_country_codes,
        'restriction_type' => $restriction_type,
      ],
    ]);

    $restriction = new CountryCodeRestriction($config_factory);
    $this->assertSame($applies, $restriction->applies());
  }

  /**
   * Tests when the country code restriction is enforced.
   *
   * @dataProvider providerTestRestrictionEnforce
   *
   * @covers ::__construct
   * @covers ::enforce
   */
  public function testRestrictionEnforce(IPAddress $address, string $restriction_type, bool $enforce) {
    /** @var \Drupal\Core\Config\ConfigFactoryInterface */
    $config_factory = $this->getConfigFactoryStub([
      'geoblock.settings' => [
        'restriction_country_codes' => ['US', 'IE'],
        'restriction_type' => $restriction_type,
      ],
    ]);

    $restriction = new CountryCodeRestriction($config_factory);
    $this->assertSame($enforce, $restriction->enforce($address));
  }

}
