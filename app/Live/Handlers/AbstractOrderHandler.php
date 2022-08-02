<?php
namespace RealEstate\Live\Handlers;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Company\Services\PermissionService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\User\Entities\User;
use RealEstate\Live\Support\AbstractHandler;
use RealEstate\Live\Support\Channel;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractOrderHandler extends AbstractHandler
{
    /**
     * @return string
     */
    protected function getType()
    {
        return 'order';
    }

    /**
     * @param object $notification
     * @return Channel[]
     */
    protected function getChannels($notification)
    {
        if (!$notification instanceof AbstractNotification){
            throw new RuntimeException('Unable to determine channels for the "'.get_class($notification).'" notification.');
        }

        $order = $notification->getOrder();

        return $this->buildChannels($order->getAssignee(),  $order->getCustomer());
    }

    /**
     * @param User $assignee
     * @param Customer $customer
     * @return Channel[]
     */
    protected function buildChannels(User $assignee, Customer $customer)
    {
        $channels = [];

        $channels[] = new Channel($assignee);

        if ($assignee instanceof Appraiser){
            $channels[] = new Channel($customer, $assignee);

            /**
             * @var PermissionService $permissionService
             */
            $permissionService = $this->container->make(PermissionService::class);

            $managers = $permissionService->getAllManagersByAppraiserId($assignee->getId());

            foreach ($managers as $manager){
                $channels[] = new Channel($manager);
            }
        }

        return $channels;
    }
}