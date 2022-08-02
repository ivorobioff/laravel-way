<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateAdditionalDocumentHandler extends BaseHandler
{
	/**
	 * @param CreateAdditionalDocumentNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'create-additional-document',
			'order' => $notification->getOrder()->getId(),
			'additionalDocument' => $notification->getAdditionalDocument()->getId()
		];
	}
}