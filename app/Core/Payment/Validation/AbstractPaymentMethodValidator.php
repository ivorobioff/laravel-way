<?php
namespace RealEstate\Core\Payment\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Definer\LocationDefiner;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\LocationAwareInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractPaymentMethodValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var User
     */
    private $owner;

    /**
     * @param StateService $stateService
     * @param User $owner
     */
    public function __construct(StateService $stateService, User $owner)
    {
        $this->stateService = $stateService;
        $this->owner = $owner;
    }

    /**
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
        (new LocationDefiner($this->stateService))
            ->setSingleAddress(true)
            ->setObligate(!($this->owner instanceof LocationAwareInterface))
            ->define($binder);
    }
}