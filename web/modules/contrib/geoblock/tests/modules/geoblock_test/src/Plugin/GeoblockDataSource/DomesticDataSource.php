<?php

declare(strict_types=1);

namespace Drupal\geoblock_test\Plugin\GeoblockDataSource;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\State\StateInterface;

use Drupal\geoblock\IPAddress;
use Drupal\geoblock\Plugin\GeoblockDataSourcePluginBase;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A domestic geoblock data source plugin.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @GeoblockDataSource(
 *   id = "domestic",
 *   label = "Domestic",
 * )
 */
class DomesticDataSource extends GeoblockDataSourcePluginBase implements ContainerFactoryPluginInterface {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('state'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function locate(IPAddress $address): void {
    $address->setCountryCode('US');
    $address->setRegisteredCountryCode('US');

    $this->state->set('geoblock.located', TRUE);
  }

}
