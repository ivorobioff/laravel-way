<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientBelong extends AbstractRule
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

        $this->setMessage('The provided client does not belong to the provided customer.');
        $this->setIdentifier('not-belong');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$this->customerService->hasClient($this->customer->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}