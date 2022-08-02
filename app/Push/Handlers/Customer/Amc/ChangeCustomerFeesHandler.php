<?php
namespace RealEstate\Push\Handlers\Customer\Amc;

use RealEstate\Core\Amc\Notifications\ChangeCustomerFeesNotification;
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
            'type' => 'amc',
            'event' => 'change-customer-fees',
            'amc' => $notification->getAmc()->getId(),
            'scope' => (string) $notification->getScope(),
            'jobType' => object_take($notification, 'jobType.id'),
            'state' => object_take($notification, 'state.code')
        ];
    }
}