<?php
namespace RealEstate\Core\Assignee\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Assignee\Services\AssigneeService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeAvailableForCustomerFee extends AbstractRule
{
    /**
     * @var AssigneeService|AppraiserService|AmcService
     */
    private $assigneeService;

    /**
     * @var User|Appraiser|Amc
     */
    private $assignee;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param AssigneeService|AppraiserService|AmcService $assigneeService
     * @param User|Appraiser|Amc $assignee
     * @param Customer $customer
     */
    public function __construct(AssigneeService $assigneeService, User $assignee, Customer $customer)
    {
        $this->assigneeService = $assigneeService;
        $this->assignee = $assignee;
        $this->customer = $customer;

        $this->setIdentifier('already-taken');
        $this->setMessage('A customer fee has been already set for the provided job type.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $taken = $this->assigneeService->hasCustomerFeeWithJobType(
            $this->assignee->getId(),
            $this->customer->getId(),
            $value
        );

        if ($taken){
            return $this->getError();
        }

        return null;
    }
}
