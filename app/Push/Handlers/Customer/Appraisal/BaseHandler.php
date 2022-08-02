<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class BaseHandler extends AbstractHandler
{
	/**
	 * @param AbstractNotification $notification
	 * @return Call[]
	 */
	public function getCalls($notification)
	{
		$customer = $notification->getOrder()->getCustomer();

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