<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeclineOrderHandler extends BaseHandler
{
	/**
	 * @param DeclineOrderNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'decline',
			'order' => $notification->getOrder()->getId(),
			'reason' => $notification->getReason()->value(),
			'message' => $notification->getMessage()
		];
	}
}