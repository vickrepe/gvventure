<?php

declare(strict_types=1);

namespace Drupal\geoblock\Restriction;

use Drupal\Core\Config\ConfigFactoryInterface;

use Drupal\geoblock\IPAddress;

/**
 * Defines a country code restriction for IP addresses.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
class CountryCodeRestriction implements RestrictionInterface {

  /**
   * The country codes defining the restriction group.
   *
   * @var string[]|null
   */
  protected $restrictionCountryCodes = NULL;

  /**
   * The restriction type to enforce (or NULL if none).
   *
   * @var string|null
   */
  protected $restrictionType = NULL;

  /**
   * Constructs a CountryCodeRestriction object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $config = $config_factory->get('geoblock.settings');

    $restriction_country_codes = $config->get('restriction_country_codes');
    if (\is_array($restriction_country_codes)) {
      $this->restrictionCountryCodes = $restriction_country_codes;
    }

    $restriction_type = $config->get('restriction_type');
    if (\in_array($restriction_type, ['allow', 'block'], TRUE)) {
      $this->restrictionType = $restriction_type;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function applies(): bool {
    if (isset($this->restrictionCountryCodes, $this->restrictionType)) {
      return \count($this->restrictionCountryCodes) > 0;
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function enforce(IPAddress $address): bool {
    if ($country_code = $address->getCountryCode()) {
      $is_restriction_member = \in_array($country_code, $this->restrictionCountryCodes, TRUE);
      $is_restriction_type_allow = ($this->restrictionType === 'allow');

      if ($is_restriction_member ^ $is_restriction_type_allow) {
        return TRUE;
      }
    }

    return FALSE;
  }

}
