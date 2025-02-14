<?php

declare(strict_types=1);

namespace Drupal\geoblock\Restriction;

use Drupal\geoblock\IPAddress;

/**
 * An interface used to describe a configurable restriction.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
interface RestrictionInterface {

  /**
   * Check if the restriction is applicable with the given configuration.
   *
   * @return bool
   *   TRUE if applicable, FALSE otherwise.
   */
  public function applies(): bool;

  /**
   * Check if the restriction should be enforced with the given data.
   *
   * @param \Drupal\geoblock\IPAddress $address
   *   The IP address object after being located.
   *
   * @return bool
   *   TRUE if the restriction should be enforced, FALSE otherwise.
   */
  public function enforce(IPAddress $address): bool;

}
