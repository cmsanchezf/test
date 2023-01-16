<?php

namespace Drupal\marvel_deck\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the marvel deck entity edit forms.
 */
class MarvelDeckForm extends ContentEntityForm {

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
        $this->messenger()->addStatus($this->t('New marvel deck %label has been created.', $message_arguments));
        $this->logger('marvel_deck')->notice('Created new marvel deck %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The marvel deck %label has been updated.', $message_arguments));
        $this->logger('marvel_deck')->notice('Updated marvel deck %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.marvel_deck.canonical', ['marvel_deck' => $entity->id()]);

    return $result;
  }

}
