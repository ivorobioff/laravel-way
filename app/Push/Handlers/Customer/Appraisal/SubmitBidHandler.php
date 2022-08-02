<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\SubmitBidNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SubmitBidHandler extends BaseHandler
{
	/**
	 * @param SubmitBidNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'submit-bid',
			'order' => $notification->getOrder()->getId()
		];
	}
}