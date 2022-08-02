<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteDocumentFactory extends AbstractDocumentFactory
{
	/**
	 * @return Action
	 */
	public function getAction()
	{
		return new Action(Action::DELETE_DOCUMENT);
	}

	/**
	 * @param DeleteDocumentNotification $notification
	 * @return Document
	 */
	protected function getDocument($notification)
	{
		return $notification->getDocument()->getPrimary();
	}
}