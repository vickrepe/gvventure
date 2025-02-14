<?php

namespace Drupal\Tests\geoblock\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Functional tests for this module.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @group geoblock
 */
class GeoblockFunctionalTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'geoblock',
    'geoblock_test',
  ];

  /**
   * Data provider for ::testRequests().
   */
  public function providerTestRequests() {
    return [
      'has applicable methods, has data source' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'null',
        ],
        TRUE,
        200,
      ],
      'has applicable methods, has no data source' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
        ],
        FALSE,
        200,
      ],
      'has no applicable methods, has data source' => [
        [
          'applicable_methods[]' => ['POST'],
          'data_source' => 'null',
        ],
        FALSE,
        200,
      ],
      'has no applicable methods, has no data source' => [
        [
          'applicable_methods[]' => ['POST'],
        ],
        FALSE,
        200,
      ],
      'has applicable methods, has data source, satisfies domestic use' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'domestic',
          'require_domestic_use' => TRUE,
        ],
        TRUE,
        200,
      ],
      'has applicable methods, has data source, violates domestic use' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'international',
          'require_domestic_use' => TRUE,
        ],
        TRUE,
        403,
      ],
      'has applicable methods, has data source, restriction_type allow US, address in US' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'domestic',
          'restriction_country_codes[]' => ['IM', 'US'],
          'restriction_type' => 'allow',
        ],
        TRUE,
        200,
      ],
      'has applicable methods, has data source, restriction_type allow US, address not in US' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'international',
          'restriction_country_codes[]' => ['IM', 'US'],
          'restriction_type' => 'allow',
        ],
        TRUE,
        403,
      ],
      'has applicable methods, has data source, restriction_type block US, address in US' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'domestic',
          'restriction_country_codes[]' => ['IM', 'US'],
          'restriction_type' => 'block',
        ],
        TRUE,
        403,
      ],
      'has applicable methods, has data source, restriction_type block US, address not in US' => [
        [
          'applicable_methods[]' => ['DELETE', 'GET'],
          'data_source' => 'international',
          'restriction_country_codes[]' => ['IM', 'US'],
          'restriction_type' => 'block',
        ],
        TRUE,
        200,
      ],
    ];
  }

  /**
   * Tests requests for enforcement.
   *
   * @dataProvider providerTestRequests
   */
  public function testRequests(array $config, bool $located, int $status) {
    $this->drupalLogin($this->drupalCreateUser(['administer geoblock']));
    $this->drupalGet('admin/config/geoblock');
    $this->submitForm($config, 'Save configuration');

    $assert = $this->assertSession();
    $assert->statusCodeEquals($status);

    $state = $this->container->get('state');
    $this->assertSame($located, !empty($state->get('geoblock.located')));
  }

}
