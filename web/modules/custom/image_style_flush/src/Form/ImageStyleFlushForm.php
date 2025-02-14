<?php

namespace Drupal\image_style_flush\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageStyleFlushForm extends FormBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'image_style_flush_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $styles = $this->entityTypeManager->getStorage('image_style')->loadMultiple();
    $options = [];
    foreach ($styles as $style) {
      $options[$style->id()] = $style->label();
    }

    $form['image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Select image style'),
      '#options' => $options,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Flush image style'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $style_id = $form_state->getValue('image_style');
    $style = $this->entityTypeManager->getStorage('image_style')->load($style_id);
    if ($style) {
      $style->flush();
      $this->messenger()->addMessage($this->t('Image style %style has been flushed.', ['%style' => $style->label()]));
    } else {
      $this->messenger()->addError($this->t('Image style not found.'));
    }
  }
}
