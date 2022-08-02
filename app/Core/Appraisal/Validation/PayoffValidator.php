<?php
namespace RealEstate\Core\Appraisal\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Email;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Numeric;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Definer\LocationDefiner;
use RealEstate\Core\Payment\Validation\Rules\CreditCardNotExpired;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PayoffValidator extends AbstractThrowableValidator
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
        $binder->bind('creditCard.number', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Numeric())
                ->addRule(new Length(13, 16));
        });

        $binder->bind('creditCard.code', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Numeric())
                ->addRule(new Length(3, 4));
        });

        $binder->bind('creditCard.expiresAt', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new CreditCardNotExpired());
        });

        $binder->bind('creditCard.firstName', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank());
        });

        $binder->bind('creditCard.lastName', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank());
        });

        $binder->bind('creditCard.email', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Email());
        });

        $binder->bind('creditCard.phone', function(Property $property){
            $property
                ->addRule(new Blank());
        });

        (new LocationDefiner($this->stateService))
            ->setHolder('creditCard', false)
            ->setSingleAddress(true)
            ->define($binder);

        $binder->bind('amount', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Greater(0));
        });
    }
}