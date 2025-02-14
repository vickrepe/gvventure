<?php

declare(strict_types=1);

namespace Drupal\geoblock\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

use Drupal\geoblock\Annotation\GeoblockDataSource;

/**
 * Defines the geoblock data source plugin manager provided by this module.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
class GeoblockDataSourcePluginManager extends DefaultPluginManager implements GeoblockDataSourcePluginManagerInterface {

  /**
   * Constructs a GeoblockDataSourcePluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/GeoblockDataSource', $namespaces, $module_handler, GeoblockDataSourcePluginInterface::class, GeoblockDataSource::class);

    $this->alterInfo('geoblock_data_source_info');
    $this->setCacheBackend($cache_backend, 'geoblock_data_source_plugins');
  }

}
