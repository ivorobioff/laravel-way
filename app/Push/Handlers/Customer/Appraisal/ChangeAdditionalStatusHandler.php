<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusHandler extends BaseHandler
{
	/**
	 * @param ChangeAdditionalStatusNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'order',
			'event' => 'change-additional-status',
			'order' => $notification->getOrder()->getId(),
			'oldAdditionalStatus' => object_take($notification->getOldAdditionalStatus(), 'id'),
			'oldAdditionalStatusComment' => $notification->getOldAdditionalStatusComment(),
			'newAdditionalStatus' => object_take($notification->getNewAdditionalStatus(), 'id'),
			'newAdditionalStatusComment' => $notification->getNewAdditionalStatusComment(),
		];
	}
}