<?php
namespace RealEstate\Core\Log\Factories;
use RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateDocumentFactory extends AbstractDocumentFactory
{
    /**
     * @param UpdateDocumentNotification $notification
     * @return Document
     */
    protected function getDocument($notification)
    {
        return $notification->getDocument()->getPrimary();
    }

    /**
     * @return Action
     */
    protected function getAction()
    {
        return new Action(Action::UPDATE_DOCUMENT);
    }
}