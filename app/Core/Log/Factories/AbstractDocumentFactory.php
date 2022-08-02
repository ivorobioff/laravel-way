<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\Extra;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractDocumentFactory extends AbstractFactory
{
	/**
	 * @param AbstractNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		/**
		 * @var DocumentPreferenceInterface $preference
		 */
		$preference = $this->container->get(DocumentPreferenceInterface::class);

		$log = parent::create($notification);

		$log->setAction($this->getAction());

		$document = $this->getDocument($notification);

		$extra = $log->getExtra();

		$extra[Extra::NAME] = $document->getName();
		$extra[Extra::FORMAT] = (string) $document->getFormat();
		$extra[Extra::URL] = Shortcut::extractUrlFromDocument($document, $preference);
		$extra[Extra::SIZE] = $document->getSize();

		return $log;
	}

	/**
	 * @param object $notification
	 * @return Document
	 */
	abstract protected function getDocument($notification);

	/**
	 * @return Action
	 */
	abstract protected function getAction();
}