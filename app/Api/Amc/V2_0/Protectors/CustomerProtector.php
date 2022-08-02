<?php
namespace RealEstate\Api\Amc\V2_0\Protectors;

use RealEstate\Api\Assignee\V2_0\Protectors\AbstractCustomerProtector;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CustomerProtector extends AbstractCustomerProtector
{
    /**
     * @param int $customerId
     * @param int $assigneeId
     * @return bool
     */
    function isRelated($customerId, $assigneeId)
    {
        /**
         * @var CustomerService $customerService
         */
        $customerService = $this->container->make(CustomerService::class);

        return $customerService->isRelatedWithAmc($customerId, $assigneeId);
    }
}