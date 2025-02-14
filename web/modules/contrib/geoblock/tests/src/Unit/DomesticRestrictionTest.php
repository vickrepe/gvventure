<?php

namespace Drupal\Tests\geoblock\Unit;

use Drupal\geoblock\IPAddress;
use Drupal\geoblock\Restriction\DomesticRestriction;

use Drupal\Tests\UnitTestCase;

/**
 * Unit tests for the domestic use restriction.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @coversDefaultClass \Drupal\geoblock\Restriction\DomesticRestriction
 * @group geoblock
 */
class DomesticRestrictionTest extends UnitTestCase {

  /**
   * Data provider for ::testRestriction().
   */
  public function providerTestRestriction() {
    $domestic = new IPAddress('10.0.0.1');
    $international = new IPAddress('10.0.0.1');

    $domestic->setCountryCode('US');
    $domestic->setRegisteredCountryCode('US');

    $international->setCountryCode('US');
    $international->setRegisteredCountryCode('IE');

    return [
      'applies, domestic use' => [
        $domestic,
        TRUE,
        FALSE,
      ],
      'applies, international use' => [
        $international,
        TRUE,
        TRUE,
      ],
      'does not apply, domestic use' => [
        $domestic,
        FALSE,
        FALSE,
      ],
      'does not apply, international use' => [
        $international,
        FALSE,
        TRUE,
      ],
    ];
  }

  /**
   * Tests the domestic use restriction.
   *
   * @dataProvider providerTestRestriction
   *
   * @covers ::__construct
   * @covers ::applies
   * @covers ::enforce
   */
  public function testRestriction(IPAddress $address, bool $applies, bool $enforce) {
    /** @var \Drupal\Core\Config\ConfigFactoryInterface */
    $config_factory = $this->getConfigFactoryStub([
      'geoblock.settings' => [
        'require_domestic_use' => $applies,
      ],
    ]);

    $restriction = new DomesticRestriction($config_factory);

    $this->assertSame($applies, $restriction->applies());
    $this->assertSame($enforce, $restriction->enforce($address));
  }

}
