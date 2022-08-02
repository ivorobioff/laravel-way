<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateDocumentHandler extends BaseHandler
{
	/**
	 * @param UpdateDocumentNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'update-document',
			'order' => $notification->getOrder()->getId(),
			'document' => $notification->getDocument()->getId()
		];
	}
}