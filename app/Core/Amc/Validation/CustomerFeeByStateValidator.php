<?php
namespace RealEstate\Core\Amc\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Amc\Entities\CustomerFeeByState;
use RealEstate\Core\Amc\Services\CustomerFeeService;
use RealEstate\Core\Amc\Validation\Rules\CustomerFeeByStateStateUnique;
use RealEstate\Core\Assignee\Entities\CustomerFee;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Rules\StateExists;
use RealEstate\Core\Support\Service\ContainerInterface;

class CustomerFeeByStateValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var CustomerFeeService
     */
    private $feeService;

    /**
     * @var CustomerFeeByState
     */
    private $currentFeeByState;

    /**
     * @var CustomerFee
     */
    private $currentFee;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->feeService = $container->get(CustomerFeeService::class);
        $this->stateService = $container->get(StateService::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('state', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new StateExists($this->stateService))
                ->addRule(new CustomerFeeByStateStateUnique($this->feeService, $this->currentFee, $this->currentFeeByState));
        });

        $binder->bind('amount', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Greater(0));
        });
    }

    /**
     * @param CustomerFeeByState $feeByState
     * @return $this
     */
    public function setCurrentFeeByState(CustomerFeeByState $feeByState)
    {
        $this->currentFeeByState = $feeByState;
        return $this;
    }

    /**
     * @param CustomerFee $fee
     * @return $this
     */
    public function setCurrentFee(CustomerFee $fee)
    {
        $this->currentFee = $fee;
        return $this;
    }
}
