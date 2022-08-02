<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateOrderFactory extends AbstractOrderFactory
{
	/**
	 * @param UpdateOrderNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$log->setAction(new Action(Action::UPDATE_ORDER));

		return $log;
	}
}