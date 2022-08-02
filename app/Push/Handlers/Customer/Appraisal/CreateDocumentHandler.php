<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateDocumentHandler extends BaseHandler
{
	/**
	 * @param CreateDocumentNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'create-document',
			'order' => $notification->getOrder()->getId(),
			'document' => $notification->getDocument()->getId()
		];
	}
}