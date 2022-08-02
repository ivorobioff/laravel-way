<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateDocumentFactory extends AbstractDocumentFactory
{
	/**
	 * @return Action
	 */
	public function getAction()
	{
		return new Action(Action::CREATE_DOCUMENT);
	}

	/**
	 * @param CreateDocumentNotification $notification
	 * @return Document
	 */
	protected function getDocument($notification)
	{
		return $notification->getDocument()->getPrimary();
	}
}