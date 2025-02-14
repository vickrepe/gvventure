<?php

declare(strict_types=1);

namespace Drupal\geoblock\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\geoblock\Plugin\GeoblockDataSourcePluginManagerInterface;

use League\ISO3166\ISO3166;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a configuration form for this module.
 *
 * Copyright (C) 2022  Library Solutions, LLC (et al.).
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * A list of HTTP request methods supported by this module.
   *
   * @var string[]
   */
  const REQUEST_METHODS = [
    'CONNECT',
    'DELETE',
    'GET',
    'HEAD',
    'OPTIONS',
    'PATCH',
    'POST',
    'PUT',
    'TRACE',
  ];

  /**
   * The geoblock data source plugin manager service.
   *
   * @var \Drupal\geoblock\Plugin\GeoblockDataSourcePluginManagerInterface
   */
  protected $geoblockDataSourcePluginManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, TypedConfigManagerInterface $typed_config_manager, GeoblockDataSourcePluginManagerInterface $geoblock_data_source_plugin_manager) {
    parent::__construct($config_factory, $typed_config_manager);

    $this->geoblockDataSourcePluginManager = $geoblock_data_source_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(current($this->getEditableConfigNames()));
    $form = parent::buildForm($form, $form_state);

    $form['data_source'] = [
      '#type' => 'select',
      '#title' => $this->t('Data source'),
      '#description' => $this->t('The data source plugin may require further configuration; consult its documentation for further instructions. If no data source is selected, this module is effectively disabled.'),
      '#default_value' => $config->get('data_source'),
      '#empty_option' => $this->t('- None -'),
      '#options' => $this->getDataSourcePluginOptions(),
    ];

    $form['applicable_methods'] = [
      '#type' => 'select',
      '#title' => $this->t('Applicable HTTP methods'),
      '#description' => $this->t('Select the HTTP request methods for which all restrictions are applied. If no methods are selected, this module is effectively disabled.'),
      '#value_callback' => [$this, 'selectValueCallback'],
      '#default_value' => $config->get('applicable_methods'),
      '#options' => $this->getRequestMethodOptions(),
      '#multiple' => TRUE,
    ];

    $form['enable_logging'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable logging'),
      '#description' => $this->t('If enabled, log messages will be recorded when a restriction has been enforced.'),
      '#default_value' => $config->get('enable_logging'),
    ];

    $form['require_domestic_use'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Require domestic use'),
      '#description' => $this->t('If enabled, any IP address being used in a different country than its registered country will be blocked.'),
      '#default_value' => $config->get('require_domestic_use'),
    ];

    $form['restriction_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Restriction type'),
      '#description' => $this->t('The selected restriction type will determine how country restrictions are enforced.'),
      '#default_value' => $config->get('restriction_type'),
      '#empty_option' => $this->t('Do not enforce country restrictions'),
      '#options' => [
        'allow' => $this->t('Allow only the selected countries'),
        'block' => $this->t('Block the selected countries'),
      ],
    ];

    $form['restriction_country_codes'] = [
      '#type' => 'select',
      '#title' => $this->t('Restriction countries'),
      '#description' => $this->t('Select the countries for which to apply the configured restriction type.'),
      '#value_callback' => [$this, 'selectValueCallback'],
      '#default_value' => $config->get('restriction_country_codes'),
      '#options' => $this->getCountryCodeOptions(),
      '#multiple' => TRUE,
      '#states' => [
        'enabled' => [
          'select[name="restriction_type"]' => [
            '!value' => '',
          ],
        ],
        'required' => [
          'select[name="restriction_type"]' => [
            '!value' => '',
          ],
        ],
        'visible' => [
          'select[name="restriction_type"]' => [
            '!value' => '',
          ],
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('plugin.manager.geoblock_data_source'),
    );
  }

  /**
   * Get a list of country code options.
   *
   * @return array
   *   A list of country code options.
   */
  protected function getCountryCodeOptions(): array {
    $options = [];

    foreach ((new ISO3166())->all() as $country) {
      $options[\strtoupper($country['alpha2'])] = $country['name'];
    }

    return $options;
  }

  /**
   * Get a list of data source plugin options.
   *
   * @return array
   *   A list of data source plugin options.
   */
  protected function getDataSourcePluginOptions(): array {
    $options = [];

    $plugins = $this->geoblockDataSourcePluginManager->getDefinitions();
    foreach ($plugins as $name => $plugin) {
      $options[$name] = $plugin['label'];
    }

    return $options;
  }

  /**
   * Get a list of request method options.
   *
   * @return array
   *   A list of request method options.
   */
  protected function getRequestMethodOptions(): array {
    return \array_combine(self::REQUEST_METHODS, self::REQUEST_METHODS);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'geoblock.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'geoblock_settings';
  }

  /**
   * Compute the value for a multi-select element on this form.
   *
   * @param array $element
   *   The processed element for which to retrieve a value.
   * @param mixed $input
   *   The element value.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return mixed
   *   The element value.
   */
  public function selectValueCallback(array &$element, $input, FormStateInterface $form_state) {
    if ($input !== FALSE) {
      if (empty($element['#disabled']) && \is_array($input)) {
        return \array_values($input);
      }

      return [];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(\current($this->getEditableConfigNames()));
    $config->setData($form_state->cleanValues()->getValues());
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
