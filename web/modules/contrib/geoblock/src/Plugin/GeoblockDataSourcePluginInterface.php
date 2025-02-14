<?php

declare(strict_types=1);

namespace Drupal\geoblock\Plugin;

use Drupal\geoblock\IPAddress;

/**
 * An interface used to describe a geoblock data source plugin.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
interface GeoblockDataSourcePluginInterface {

  /**
   * Locate the supplied IP address and decorate it with location information.
   *
   * The IP address should be geolocated by the data source, then the plugin
   * will fill in any available location information.
   *
   * The following types of location information are supported:
   * - The country where the IP is being used.
   * - The country where the IP address was registered.
   *
   * @param \Drupal\geoblock\IPAddress $address
   *   The IP address to be decorated with location information.
   *
   * @throws \Throwable
   *   If an unrecoverable error occurs.
   */
  public function locate(IPAddress $address): void;

}
