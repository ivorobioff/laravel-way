<?php
namespace RealEstate\Core\Amc\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeAccess extends AbstractRule
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var AmcService
     */
    private $amcService;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Amc
     */
    private $amc;

    /**
     * @param CustomerService $customerService
     * @param AmcService $amcService
     * @param Customer $customer
     * @param Amc $amc
     */
    public function __construct(
        CustomerService $customerService,
        AmcService $amcService,
        Customer $customer,
        Amc $amc
    )
    {
        $this->customerService = $customerService;
        $this->amcService = $amcService;
        $this->customer = $customer;
        $this->amc = $amc;

        $this->setIdentifier('access');
        $this->setMessage('Unable to proceed with the provided job type.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$this->customerService->hasPayableJobType($this->customer->getId(), $value)){
            return $this->getError();
        }

        if (!$this->amcService->isRelatedWithCustomer($this->amc->getId(), $this->customer->getId())){
            return $this->getError();
        }

        return null;
    }
}
