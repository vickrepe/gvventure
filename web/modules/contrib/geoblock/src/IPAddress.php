<?php

declare(strict_types=1);

namespace Drupal\geoblock;

use League\ISO3166\ISO3166;

/**
 * An object used to represent an IP address and its affiliated location(s).
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
final class IPAddress {

  const FILTER = \FILTER_VALIDATE_IP;
  const FILTER_FLAGS = \FILTER_FLAG_IPV4 | \FILTER_FLAG_IPV6;
  const FILTER_FLAGS_PUBLIC = \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE;

  /**
   * The IP address.
   *
   * @var string
   */
  protected $address;

  /**
   * The country associated with the IP address at the time of use.
   *
   * This value is a country code from the ISO 3166-1 alpha-2 standard.
   *
   * @var string|null
   */
  protected $countryCode = NULL;

  /**
   * The country where the IP address was registered.
   *
   * This value is a country code from the ISO 3166-1 alpha-2 standard.
   *
   * @var string|null
   */
  protected $registeredCountryCode = NULL;

  /**
   * Constructs an IPAddress object.
   *
   * @param string $address
   *   The IP address to represent.
   *
   * @throws \InvalidArgumentException
   *   If the IP address is neither a valid IPv4 nor IPv6 address.
   */
  public function __construct(string $address) {
    $address = \filter_var($address, self::FILTER, self::FILTER_FLAGS);

    if ($address === FALSE) {
      throw new \InvalidArgumentException('An invalid address was supplied; the supplied IP address must be a valid IPv4 or IPv6 address');
    }

    $this->address = $address;
  }

  /**
   * Get the IP address represented by this object.
   *
   * @return string
   *   The IP address represented by this object.
   */
  public function getAddress(): string {
    return $this->address;
  }

  /**
   * Get the ISO 3166-1 alpha-2 country code for this IP address.
   *
   * @return string|null
   *   The country associated with the IP address at the time of use. If the
   *   country couldn't be determined, NULL is returned.
   */
  public function getCountryCode(): ?string {
    return $this->countryCode;
  }

  /**
   * Get the ISO 3166-1 alpha-2 registered country code for this IP address.
   *
   * @return string|null
   *   The country where the IP address was registered. If the country couldn't
   *   be determined, NULL is returned.
   */
  public function getRegisteredCountryCode(): ?string {
    return $this->registeredCountryCode;
  }

  /**
   * Check if the IP address is being used domestically.
   *
   * This method will assume domestic use when only one country code has been
   * located for this address.
   *
   * @return bool
   *   TRUE if domestic use, FALSE otherwise.
   */
  public function isDomesticUse(): bool {
    if (isset($this->countryCode, $this->registeredCountryCode)) {
      return $this->countryCode === $this->registeredCountryCode;
    }

    return TRUE;
  }

  /**
   * Check if the IP address is public.
   *
   * An IP address is public if it doesn't belong to a private/reserved range.
   *
   * @return bool
   *   TRUE if the address is public, FALSE otherwise.
   */
  public function isPublic(): bool {
    return \filter_var($this->address, self::FILTER, self::FILTER_FLAGS | self::FILTER_FLAGS_PUBLIC) !== FALSE;
  }

  /**
   * Set the ISO 3166-1 alpha-2 country code for this IP address.
   *
   * @param string $country_code
   *   The country associated with the IP address at the time of use.
   *
   * @throws \InvalidArgumentException
   *   If the supplied input is not a valid ISO 3166-1 alpha-2 country code.
   */
  public function setCountryCode(string $country_code): void {
    $country_code = \strtoupper($country_code);

    if (!$this->validateCountryCode($country_code)) {
      throw new \InvalidArgumentException("{$country_code} is not a valid ISO 3166-1 alpha-2 country code");
    }

    $this->countryCode = $country_code;
  }

  /**
   * Set the ISO 3166-1 alpha-2 registered country code for this IP address.
   *
   * @param string $country_code
   *   The country where the IP address was registered.
   *
   * @throws \InvalidArgumentException
   *   If the supplied input is not a valid ISO 3166-1 alpha-2 country code.
   */
  public function setRegisteredCountryCode(string $country_code): void {
    $country_code = \strtoupper($country_code);

    if (!$this->validateCountryCode($country_code)) {
      throw new \InvalidArgumentException("{$country_code} is not a valid ISO 3166-1 alpha-2 country code");
    }

    $this->registeredCountryCode = $country_code;
  }

  /**
   * Check if the supplied input is a valid ISO 3166-1 alpha-2 country code.
   *
   * @param string $input
   *   The input string to check.
   *
   * @return bool
   *   TRUE if valid, FALSE otherwise.
   */
  protected function validateCountryCode(string $input): bool {
    $valid = FALSE;

    try {
      $valid = !empty((new ISO3166())->alpha2($input));
    }
    catch (\Throwable $e) {
    }

    return $valid;
  }

}
