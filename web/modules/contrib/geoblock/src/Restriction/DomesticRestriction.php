<?php

declare(strict_types=1);

namespace Drupal\geoblock\Restriction;

use Drupal\Core\Config\ConfigFactoryInterface;

use Drupal\geoblock\IPAddress;

/**
 * Defines a domestic use restriction for IP addresses.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
class DomesticRestriction implements RestrictionInterface {

  /**
   * Whether to require domestic use of IP addresses.
   *
   * @var bool
   */
  protected $requireDomesticUse = FALSE;

  /**
   * Constructs a DomesticRestriction object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $config = $config_factory->get('geoblock.settings');

    if (!empty($config->get('require_domestic_use'))) {
      $this->requireDomesticUse = TRUE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function applies(): bool {
    return $this->requireDomesticUse;
  }

  /**
   * {@inheritdoc}
   */
  public function enforce(IPAddress $address): bool {
    return !$address->isDomesticUse();
  }

}
