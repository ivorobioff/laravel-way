<?php
namespace RealEstate\Core\Amc\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Amc\Entities\Fee;
use RealEstate\Core\Amc\Entities\FeeByState;
use RealEstate\Core\Amc\Services\FeeService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeByStateStateUnique extends AbstractRule
{
    /**
     * @var FeeByState
     */
    private $ignoreFeeByState;

    /**
     * @var Fee $fee
     */
    private $fee;

    /**
     * @var FeeService
     */
    private $feeService;

    public function __construct(FeeService $feeService, Fee $fee, FeeByState $feeByState = null)
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

        if ($this->feeService->hasFeeByStateByStateCode($this->fee->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}