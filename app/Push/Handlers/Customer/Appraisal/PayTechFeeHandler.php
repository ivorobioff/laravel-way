<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\PayTechFeeNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PayTechFeeHandler extends BaseHandler
{
	/**
	 * @param PayTechFeeNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'pay-tech-fee',
			'order' => $notification->getOrder()->getId()
		];
	}
}