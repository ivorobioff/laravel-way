<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalStatusTransformer;
use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'change-additional-status';
	}

	/**
	 * @param ChangeAdditionalStatusNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		return [
			'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
			'oldAdditionalStatus' => $this->transformer(AdditionalStatusTransformer::class)
				->transform($notification->getOldAdditionalStatus()),
			'oldAdditionalStatusComment' => $notification->getOldAdditionalStatusComment(),
			'newAdditionalStatus' => $this->transformer(AdditionalStatusTransformer::class)
				->transform($notification->getNewAdditionalStatus()),
			'newAdditionalStatusComment' => $notification->getNewAdditionalStatusComment(),
		];
	}
}