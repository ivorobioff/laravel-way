<?php
namespace RealEstate\Core\Amc\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Amc\Entities\CustomerFeeByState;
use RealEstate\Core\Amc\Services\CustomerFeeService;
use RealEstate\Core\Assignee\Entities\CustomerFee;

class CustomerFeeByStateStateUnique extends AbstractRule
{
    /**
     * @var CustomerFeeByState
     */
    private $ignoreFeeByState;

    /**
     * @var CustomerFee
     */
    private $fee;

    /**
     * @var CustomerFeeService
     */
    private $feeService;

    /**
     * @param CustomerFeeService $feeService
     * @param CustomerFee $fee
     * @param CustomerFeeByState $feeByState
     */
    public function __construct(
        CustomerFeeService $feeService,
        CustomerFee $fee,
        CustomerFeeByState $feeByState = null
    )
    {
        $this->feeService = $feeService;
        $this->ignoreFeeByState = $feeByState;
        $this->fee = $fee;
        $this->setIdentifier('already-taken');
        $this->setMessage('The provided state is already taken in the scope of the provided fee.');
    }

    /**
     * @param mixed|Value $value
     * @return Error
     */
    public function check($value)
    {
        if ($this->ignoreFeeByState && $this->ignoreFeeByState->getState()->getCode() === $value){
            return null;
        }

        if ($this->feeService->hasCustomerFeeByStateByStateCode($this->fee->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}