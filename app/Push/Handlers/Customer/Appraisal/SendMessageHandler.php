<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SendMessageHandler extends BaseHandler
{
	/**
	 * @param SendMessageNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'send-message',
			'order' => $notification->getOrder()->getId(),
			'message' => $notification->getMessage()->getId()
		];
	}
}