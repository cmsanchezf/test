<?php

namespace Drupal\marvel_card\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the marvel card entity edit forms.
 */
class MarvelCardForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New marvel card %label has been created.', $message_arguments));
        $this->logger('marvel_card')->notice('Created new marvel card %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The marvel card %label has been updated.', $message_arguments));
        $this->logger('marvel_card')->notice('Updated marvel card %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.marvel_card.canonical', ['marvel_card' => $entity->id()]);

    return $result;
  }

}
