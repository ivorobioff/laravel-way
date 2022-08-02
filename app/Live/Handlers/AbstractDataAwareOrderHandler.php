<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractDataAwareOrderHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		return $this->transformer(OrderTransformer::class)
			->setIncludes(['processStatus'])
			->transform($notification->getOrder());
	}
}