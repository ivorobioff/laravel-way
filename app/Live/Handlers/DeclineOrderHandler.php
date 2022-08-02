<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeclineOrderHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'decline';
	}

	/**
	 * @param DeclineOrderNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		$reason = $notification->getReason();

		if ($reason !== null){
			$reason = $reason->value();
		}

		return [
			'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
			'reason' =>  $reason,
			'message' => $notification->getMessage()
		];
	}
}