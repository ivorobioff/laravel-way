<?php
namespace RealEstate\Core\Assignee\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Amc\Validation\Rules\JobTypeAccess as AmcJobTypeAccess;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Appraiser\Validation\Rules\JobTypeAccess as AppraiserJobTypeAccess;
use RealEstate\Core\Assignee\Validation\Rules\JobTypeAvailableForCustomerFee;
use RealEstate\Core\Assignee\Services\AssigneeService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Customer\Services\JobTypeService;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Entities\User;

class CreateCustomerFeeValidator extends AbstractFeeValidator
{
    /**
     * @var JobTypeService
     */
    private $jobTypeService;

    /**
     * @var AssigneeService|AppraiserService|AmcService
     */
    private $assigneeService;

    /**
     * @var CustomerService
     */
    private $customerService;
    /**
     * @var User|Appraiser|Amc
     */
    private $assignee;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param ContainerInterface $container
     * @param User|Appraiser|Amc $assignee
     * @param Customer $customer
     * @param string $assigneeService
     */
    public function __construct(
        ContainerInterface $container,
        User $assignee,
        Customer $customer,
        $assigneeService
    )
    {
        $this->assignee = $assignee;
        $this->customer = $customer;

        $this->jobTypeService = $container->get(JobTypeService::class);
        $this->customerService = $container->get(CustomerService::class);
        $this->assigneeService = $container->get($assigneeService);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('jobType', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule($this->getJobTypeAccess());

            $property->addRule(new JobTypeAvailableForCustomerFee(
                $this->assigneeService,
                $this->assignee,
                $this->customer
            ));
        });

        $this->defineAmount($binder);
    }

    /**
     * @return AppraiserJobTypeAccess|AmcJobTypeAccess
     */
    private function getJobTypeAccess()
    {
        if ($this->assignee instanceof Appraiser) {
            return $this->getAppraiserJobTypeAccess();
        }

        if ($this->assignee instanceof Amc) {
            return $this->getAmcJobTypeAccess();
        }
    }

    /**
     * @return AppraiserJobTypeAccess
     */
    private function getAppraiserJobTypeAccess()
    {
        return new AppraiserJobTypeAccess(
            $this->customerService,
            $this->assigneeService,
            $this->customer,
            $this->assignee
        );
    }

    /**
     * @var AmcJobTypeAccess
     */
    private function getAmcJobTypeAccess()
    {
        return new AmcJobTypeAccess(
            $this->customerService,
            $this->assigneeService,
            $this->customer,
            $this->assignee
        );
    }
}
