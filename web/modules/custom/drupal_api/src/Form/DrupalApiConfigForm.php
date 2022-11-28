<?php

namespace Drupal\drupal_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;

/**
 * Configure example settings for this site.
 */
class DrupalApiConfigForm extends ConfigFormBase {

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
    $client = \Drupal::httpClient();
    $request = $client->request('GET', 'https://www.drupal.org/api-d7/node.json?field_project_machine_name='.$values['project']);
    $response = $request->getBody()->getContents();

    if (!json_decode($response)->list) {
      $form_state->setError($form, $this->t('You should provide the machine name of a current mantained project at drupal.org'));
    } else {
      $this->configFactory->getEditable('drupal_api_config.settings')
    // Set the submitted configuration setting.
    ->set('drupal_api.project_nid', json_decode($response)->list[0]->nid)
    ->set('drupal_api.project_name', json_decode($response)->list[0]->title)
    ->save();
    }
  }
}
