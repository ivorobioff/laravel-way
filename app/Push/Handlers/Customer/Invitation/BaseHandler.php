<?php
namespace RealEstate\Push\Handlers\Customer\Invitation;

use RealEstate\Core\Invitation\Notifications\AbstractNotification;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class BaseHandler extends AbstractHandler
{
	/**
	 * @param AbstractNotification $notification
	 * @return array
	 */
	protected function getCalls($notification)
	{
		$customer = $notification->getInvitation()->getCustomer();

		$url = $customer->getSettings()->getPushUrl();

		if ($url === null){
			return [];
		}

		$call = new Call();

		$call->setUrl($url);
		$call->setSecret1($customer->getSecret1());
		$call->setSecret2($customer->getSecret2());

		return [$call];
	}
}