<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Amc\Entities\Fee;
use RealEstate\Core\Amc\Entities\FeeByState;
use RealEstate\Core\Amc\Services\FeeService;
use RealEstate\Core\Amc\Validation\Rules\FeeByStateStateUnique;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Rules\StateExists;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeByStateValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var FeeService
     */
    private $feeService;

    /**
     * @var FeeByState
     */
    private $currentFeeByState;

    /**
     * @var Fee
     */
    private $currentFee;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->feeService = $container->get(FeeService::class);
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
                ->addRule(new FeeByStateStateUnique($this->feeService, $this->currentFee, $this->currentFeeByState));
        });

        $binder->bind('amount', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Greater(0));
        });
    }

    /**
     * @param FeeByState $feeByState
     * @return $this
     */
    public function setCurrentFeeByState(FeeByState $feeByState)
    {
        $this->currentFeeByState = $feeByState;
        return $this;
    }

    /**
     * @param Fee $fee
     * @return $this
     */
    public function setCurrentFee(Fee $fee)
    {
        $this->currentFee = $fee;
        return $this;
    }
}