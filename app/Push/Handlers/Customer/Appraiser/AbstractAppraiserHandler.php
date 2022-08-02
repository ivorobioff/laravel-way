<?php
namespace RealEstate\Push\Handlers\Customer\Appraiser;

use RealEstate\Core\Appraiser\Notifications\AbstractAppraiserNotification;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\SettingsService;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractAppraiserHandler extends AbstractHandler
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param AbstractAppraiserNotification $notification
     * @return Call[]
     */
    protected function getCalls($notification)
    {
        $calls = [];

        $settings = $this->settingsService->getAllBySelectedCustomers(
            array_map(
                function(Customer $customer){ return $customer->getId();},
                iterator_to_array($notification->getAppraiser()->getCustomers())
            ));

        foreach ($settings as $single){

            $url = $single->getPushUrl();

            if ($url === null){
                continue ;
            }

            $customer = $single->getCustomer();

            $call = new Call();
            $call->setUrl($url);
            $call->setSecret1($customer->getSecret1());
            $call->setSecret2($customer->getSecret2());

            $calls[] = $call;
        }

        return $calls;
    }

    /**
     * @param AbstractAppraiserNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        return [
            'type' => 'appraiser',
            'appraiser' => $notification->getAppraiser()->getId()
        ];
    }
}