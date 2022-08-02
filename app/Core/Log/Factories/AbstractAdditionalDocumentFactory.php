<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\AbstractAdditionalDocumentNotification;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Extras\Extra;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractAdditionalDocumentFactory extends AbstractDocumentFactory
{
	/**
	 * @param AbstractAdditionalDocumentNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$type = $notification->getAdditionalDocument()->getType();

		if ($type){
			$type = $type->getTitle();
		} else {
			$type = $notification->getAdditionalDocument()->getLabel();
		}

		$log->getExtra()[Extra::TYPE] = $type;

		return $log;
	}

	/**
	 * @param AbstractAdditionalDocumentNotification $notification
	 * @return Document
	 */
	protected function getDocument($notification)
	{
		return $notification->getAdditionalDocument()->getDocument();
	}
}