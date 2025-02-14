<?php

declare(strict_types=1);

namespace Drupal\geoblock\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Utility\Error;

use Drupal\geoblock\IPAddress;
use Drupal\geoblock\Plugin\GeoblockDataSourcePluginInterface;
use Drupal\geoblock\Plugin\GeoblockDataSourcePluginManagerInterface;
use Drupal\geoblock\Restriction\RestrictionInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Applies geographical restrictions to incoming requests.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
class RequestHandler implements EventSubscriberInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The geoblock data source plugin manager service.
   *
   * @var \Drupal\geoblock\Plugin\GeoblockDataSourcePluginManagerInterface
   */
  protected $geoblockDataSourcePluginManager;

  /**
   * The logger for this class.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger = NULL;

  /**
   * The logger factory service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * A collection of restrictions to enforce.
   *
   * @var \Drupal\geoblock\Restriction\RestrictionInterface[]
   */
  protected $restrictions = [];

  /**
   * Constructs a RequestHandler object.
   */
  public function __construct(ConfigFactoryInterface $config_factory, GeoblockDataSourcePluginManagerInterface $geoblock_data_source_plugin_manager, LoggerChannelFactoryInterface $logger_factory) {
    $this->configFactory = $config_factory;
    $this->geoblockDataSourcePluginManager = $geoblock_data_source_plugin_manager;
    $this->loggerFactory = $logger_factory;
  }

  /**
   * Add a restriction used for enforcement.
   *
   * @param \Drupal\geoblock\Restriction\RestrictionInterface $restriction
   *   The restriction to add.
   */
  public function addRestriction(RestrictionInterface $restriction): void {
    $this->restrictions[] = $restriction;
  }

  /**
   * Check whether the request handler applies to the supplied request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return bool
   *   TRUE if the request handler applies, FALSE otherwise.
   */
  public function applies(Request $request): bool {
    if ($this->isDataSourcePluginAvailable()) {
      return $this->isRequestApplicable($request);
    }

    return FALSE;
  }

  /**
   * Get the configuration object for this module.
   *
   * @return \Drupal\Core\Config\ImmutableConfig
   *   The configuration object for this module.
   */
  protected function config(): ImmutableConfig {
    return $this->configFactory->get('geoblock.settings');
  }

  /**
   * Enforce restrictions for the supplied IP address (when appropriate).
   *
   * A single restriction being violated is sufficient for enforcement.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   The request event.
   * @param \Drupal\geoblock\IPAddress $address
   *   The IP address.
   */
  protected function enforce(RequestEvent $event, IPAddress $address): void {
    foreach ($this->restrictions as $restriction) {
      if ($restriction->applies() && $restriction->enforce($address)) {
        $text = 'The requested resource is inaccessible due to geographical restrictions.';

        $event->setResponse(new Response($text, Response::HTTP_FORBIDDEN, [
          'Content-Type' => 'text/plain',
        ]));

        $this->logRestrictionEnforcement($restriction, $event->getRequest(), $address);

        return;
      }
    }
  }

  /**
   * Get the data source plugin for the supplied request.
   *
   * @see ::isDataSourcePluginAvailable()
   *   The referenced method should be checked prior to invoking this method.
   *
   * @return \Drupal\geoblock\Plugin\GeoblockDataSourcePluginInterface
   *   The data source plugin for this request.
   */
  protected function getDataSourcePlugin(): GeoblockDataSourcePluginInterface {
    return $this->geoblockDataSourcePluginManager->createInstance($this->config()->get('data_source'));
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => [
        ['onRequest'],
      ],
    ];
  }

  /**
   * Check if the configured data source plugin is available.
   *
   * If no data source plugin has been selected, or if the selected plugin does
   * not exist, this method will return FALSE.
   *
   * @return bool
   *   TRUE if available, FALSE otherwise.
   */
  public function isDataSourcePluginAvailable(): bool {
    $data_source = $this->config()->get('data_source');

    if ($this->geoblockDataSourcePluginManager->hasDefinition($data_source)) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Check if the request method belongs to the set of applicable methods.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return bool
   *   TRUE if applicable, FALSE otherwise.
   */
  public function isRequestApplicable(Request $request): bool {
    $applicable_methods = $this->config()->get('applicable_methods');

    if (\is_array($applicable_methods)) {
      return \in_array($request->getRealMethod(), $applicable_methods, TRUE);
    }

    return FALSE;
  }

  /**
   * Locate the client making the supplied request.
   *
   * If the requester's IP address is non-public, it will not be located using
   * the configured data source plugin.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return \Drupal\geoblock\IPAddress
   *   The IP address object after being located (if applicable).
   */
  protected function locateRequestClient(Request $request): IPAddress {
    $address = new IPAddress($request->getClientIp());

    $this->getDataSourcePlugin()->locate($address);

    return $address;
  }

  /**
   * Conditionally log when a restriction was enforced.
   *
   * This method will log when a restriction was enforced for a given request
   * and address, but only if logging is enabled in configuration.
   *
   * @param \Drupal\geoblock\Restriction\RestrictionInterface $restriction
   *   The restriction that was enforced.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\geoblock\IPAddress $address
   *   The IP address.
   */
  protected function logRestrictionEnforcement(RestrictionInterface $restriction, Request $request, IPAddress $address): void {
    if (!empty($this->config()->get('enable_logging'))) {
      $this->logger()->info('<code>@type</code> was enforced on a @request_method request for <code>@request_uri</code> by @address (country code: @country_code, registered country code: @registered_country_code).', [
        '@type' => \get_class($restriction),
        '@request_method' => $request->getRealMethod(),
        '@request_uri' => $request->getRequestUri(),
        '@address' => $address->getAddress(),
        '@country_code' => $address->getCountryCode() ?? 'unknown',
        '@registered_country_code' => $address->getRegisteredCountryCode() ?? 'unknown',
      ]);
    }
  }

  /**
   * Get the logger for this class.
   *
   * @return \Drupal\Core\Logger\LoggerChannelInterface
   *   The logger for this class.
   */
  protected function logger(): LoggerChannelInterface {
    if (!isset($this->logger)) {
      $this->logger = $this->loggerFactory->get('geoblock');
    }

    return $this->logger;
  }

  /**
   * Attempt to enforce geographical restrictions where applicable.
   *
   * This method is fail-safe, and will not incur any side effects if an error
   * occurs during execution. A best effort is made to log exceptions.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   The request event.
   */
  public function onRequest(RequestEvent $event): void {
    try {
      if ($this->applies($request = $event->getRequest())) {
        $this->enforce($event, $this->locateRequestClient($request));
      }
    }
    catch (\Exception $e) {
      Error::logException($this->logger(), $e);
    }
    catch (\Throwable $e) {
    }
  }

}
