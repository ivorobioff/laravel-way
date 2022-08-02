<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Appraisal\V2_0\Transformers\ConditionsTransformer;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptOrderWithConditionsHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'accept-with-conditions';
	}

	/**
	 * @param AcceptOrderWithConditionsNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		return [
			'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
			'conditions' => $this->transformer(ConditionsTransformer::class)->transform($notification->getConditions())
		];
	}
}