<?php
namespace RealEstate\Core\Customer\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MultipleRulesetsBelong extends AbstractRule
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param CustomerService $customerService
     * @param Customer $customer
     */
    public function __construct(CustomerService $customerService, Customer $customer)
    {
        $this->customerService = $customerService;
        $this->customer = $customer;

        $this->setIdentifier('not-belong');
        $this->setMessage('One of the provided rulesets does not belong to the specified customer.');
    }

    /**
     * @param array $value
     * @return Error|null
     */
    public function check($value)
    {
        if (count($value) === 0){
            return null;
        }

        if (!$this->customerService->hasRulesets($this->customer->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}