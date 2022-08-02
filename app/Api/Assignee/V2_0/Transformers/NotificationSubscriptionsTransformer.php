<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Assignee\Entities\NotificationSubscription;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class NotificationSubscriptionsTransformer extends BaseTransformer
{
	/**
	 * @param NotificationSubscription[] $subscriptions
	 * @return array
	 */
	public function transform($subscriptions)
	{
		$data = [];

		foreach ($subscriptions as $subscription){
			$data[] = $this->extract($subscription);
		}

		return $data;
	}
}