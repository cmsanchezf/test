<?php

namespace Drupal\marvel_tag\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the marvel tag entity edit forms.
 */
class MarvelTagForm extends ContentEntityForm {

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
        $this->messenger()->addStatus($this->t('New marvel tag %label has been created.', $message_arguments));
        $this->logger('marvel_tag')->notice('Created new marvel tag %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The marvel tag %label has been updated.', $message_arguments));
        $this->logger('marvel_tag')->notice('Updated marvel tag %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.marvel_tag.canonical', ['marvel_tag' => $entity->id()]);

    return $result;
  }

}
