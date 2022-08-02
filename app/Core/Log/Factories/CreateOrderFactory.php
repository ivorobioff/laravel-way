<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\CreateOrderNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateOrderFactory extends AbstractOrderFactory
{
	/**
	 * @param CreateOrderNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$log->setAction(new Action(Action::CREATE_ORDER));

		return $log;
	}
}