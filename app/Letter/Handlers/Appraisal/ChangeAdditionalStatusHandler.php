<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|ChangeAdditionalStatusNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return $notification->getNewAdditionalStatus()->getTitle()
		.' - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @param AbstractNotification|ChangeAdditionalStatusNotification $notification
	 * @return array
	 */
	protected function getData(AbstractNotification $notification)
	{
		$data = parent::getData($notification);

		$data['newAdditionalStatus'] = object_take($notification, 'newAdditionalStatus.title', '');
		$data['newAdditionalStatusComment'] = $notification->getNewAdditionalStatusComment() ?? '';

		$data['oldAdditionalStatus'] = object_take($notification, 'oldAdditionalStatus.title', '');
		$data['oldAdditionalStatusComment'] = $notification->getOldAdditionalStatusComment() ?? '';

		return $data;
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.change_additional_status';
	}
}