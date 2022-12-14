<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Assignee\Persistables\NotificationSubscriptionPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'notifications' => [
				'customer' => 'int',
				'email' => 'bool'
			]
		];
	}

	/**
	 * @return NotificationSubscriptionPersistable[]
	 */
	public function createNotificationSubscriptionPersistables()
	{
		$subscriptions = $this->get('notifications');

		if (!$subscriptions){
			return [];
		}

		$persistables = [];

		foreach ($subscriptions as $subscription){
			$persistables[$subscription['customer']] = $this->performPopulation(
				new NotificationSubscriptionPersistable(), $subscription);
		}

		return $persistables;
	}
}