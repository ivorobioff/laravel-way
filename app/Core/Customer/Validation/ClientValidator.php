<?php
namespace RealEstate\Core\Customer\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Validation\Inflators\ClientAddressInflator;
use RealEstate\Core\Customer\Validation\Inflators\ClientCityInflator;
use RealEstate\Core\Customer\Validation\Inflators\ClientZipInflator;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Inflators\StateInflator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @param StateService $stateService
     */
    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('name', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('address1', new ClientAddressInflator());
        $binder->bind('address2', new ClientAddressInflator());
        $binder->bind('city', new ClientCityInflator());
        $binder->bind('zip', new ClientZipInflator());
        $binder->bind('state', (new StateInflator($this->stateService))->setRequired(false));
    }
}