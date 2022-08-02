<?php
namespace RealEstate\Push\Handlers\Customer\Appraiser;

use RealEstate\Core\Appraiser\Notifications\ChangeCustomerFeesNotification;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeCustomerFeesHandler extends AbstractHandler
{
    /**
     * @param ChangeCustomerFeesNotification $notification
     * @return Call[]
     */
    protected function getCalls($notification)
    {
        $customer = $notification->getCustomer();

        $url = $customer->getSettings()->getPushUrl();

        if (!$url){
            return [];
        }

        $call = new Call();
        $call->setUrl($url);
        $call->setSecret1($customer->getSecret1());
        $call->setSecret2($customer->getSecret2());

        return [$call];

    }

    /**
     * @param ChangeCustomerFeesNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        return [
            'type' => 'appraiser',
            'event' => 'change-customer-fees',
            'appraiser' => $notification->getAppraiser()->getId()
        ];
    }
}