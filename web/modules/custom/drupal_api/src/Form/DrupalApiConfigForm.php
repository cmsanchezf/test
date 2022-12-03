<?php

namespace Drupal\drupal_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\drupal_api\DrupalAPIClient;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure example settings for this site.
 */
class DrupalApiConfigForm extends ConfigFormBase {

  /**
   * DrupalAPIClient constructor.
   *
   * @param \Drupal\drupal_api\DrupalAPIClient $DrupalApiClient
   *   DrupalAPIClient
   */
  public function __construct(private DrupalAPIClient $DrupalApiClient) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('drupal_api.drupal_api_calls'),
      );
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupal_api_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'drupal_api_config.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('drupal_api_config.settings');

    $form['drupal_api'] = [
      '#tree' => TRUE,
      '#type' => 'fieldset',
      '#title' => $this->t('Top Issues Block settings'),
    ];

    $form['drupal_api']['project'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Project'),
      '#default_value' => $config->get('drupal_api.project'),
      '#pattern' => '^[a-z_]+$',
    ];

    $form['drupal_api']['items'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of items'),
      '#default_value' => $config->get('drupal_api.items'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues()['drupal_api'];
    // Retrieve the configuration.
    $this->configFactory->getEditable('drupal_api_config.settings')
    // Set the submitted configuration setting.
      ->set('drupal_api.project', $values['project'])
      ->set('drupal_api.items', $values['items'])
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues()['drupal_api'];
    $response = $this->DrupalApiClient->getModuleData($values['project']);
    $status = $response->getStatusCode();
    $list = json_decode($response->getBody()->getContents())->list;

    if (empty($list) || $status != '200') {
      $form_state->setError($form, $this->t('You should provide the machine name of a current mantained project at drupal.org'));
    }
    else {
      $this->configFactory->getEditable('drupal_api_config.settings')
      // Set the submitted configuration setting.
        ->set('drupal_api.project_nid', $list[0]->nid)
        ->set('drupal_api.project_name', $list[0]->title)
        ->save();
    }
  }

}
