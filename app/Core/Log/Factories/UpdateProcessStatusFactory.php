<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\Extra;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateProcessStatusFactory extends AbstractFactory
{
	/**
	 * @param UpdateProcessStatusNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$log->setAction(new Action(Action::UPDATE_PROCESS_STATUS));

		$extra = $log->getExtra();

		$extra[Extra::OLD_PROCESS_STATUS] = $notification->getOldProcessStatus();
		$extra[Extra::NEW_PROCESS_STATUS] = $notification->getNewProcessStatus();

		if ($notification->getNewProcessStatus()->is(ProcessStatus::ON_HOLD)){
			$extra[Extra::EXPLANATION] = $notification->getOrder()->getComment();
		}

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_SCHEDULED)){

			$extra[Extra::ESTIMATED_COMPLETION_DATE] =
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE];

			$extra[Extra::SCHEDULED_AT] =
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_SCHEDULED_AT];
		}

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_COMPLETED)){

			$extra[Extra::ESTIMATED_COMPLETION_DATE] =
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE];

			$extra[Extra::COMPLETED_AT] =
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_COMPLETED_AT];
		}

		return $log;
	}
}