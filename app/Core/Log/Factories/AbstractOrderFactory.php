<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Extras\Extra;
use RealEstate\Core\Log\Extras\LocationExtra;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AbstractOrderFactory extends AbstractFactory
{
	/**
	 * @param AbstractNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		/**
		 * @var Extra $extra
		 */
		$extra = $log->getExtra();

		$extra[Extra::CUSTOMER] = $log->getOrder()->getCustomer()->getName();
		$extra->merge(LocationExtra::fromProperty($notification->getOrder()->getProperty()));

		return $log;
	}
}