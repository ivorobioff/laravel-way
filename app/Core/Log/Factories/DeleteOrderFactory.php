<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteOrderFactory extends AbstractOrderFactory
{
	/**
	 * @param DeleteOrderNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$log->setOrder(null);
		
		$log->setAction(new Action(Action::DELETE_ORDER));

		return $log;
	}
}