<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateOrderHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'Updated - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.update_order';
	}
}