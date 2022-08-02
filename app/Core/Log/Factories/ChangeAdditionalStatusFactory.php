<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\AdditionalStatusExtra;
use RealEstate\Core\Log\Extras\Extra;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusFactory extends AbstractFactory
{
	/**
	 * @param ChangeAdditionalStatusNotification $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$log = parent::create($notification);

		$log->setAction(new Action(Action::CHANGE_ADDITIONAL_STATUS));

		$extra = $log->getExtra();

		if ($oldAdditionalStatus = $notification->getOldAdditionalStatus()){
			$oldAdditionalStatus = AdditionalStatusExtra::fromAdditionalStatus($oldAdditionalStatus);
		}

		$extra[Extra::OLD_ADDITIONAL_STATUS] = $oldAdditionalStatus;
		$extra[Extra::OLD_ADDITIONAL_STATUS_COMMENT] = $notification->getOldAdditionalStatusComment();

		if ($newAdditionalStatus = $notification->getNewAdditionalStatus()){
			$newAdditionalStatus = AdditionalStatusExtra::fromAdditionalStatus($newAdditionalStatus);
		}

		$extra[Extra::NEW_ADDITIONAL_STATUS] = $newAdditionalStatus;
		$extra[Extra::NEW_ADDITIONAL_STATUS_COMMENT] = $notification->getNewAdditionalStatusComment();

		return $log;
	}
}