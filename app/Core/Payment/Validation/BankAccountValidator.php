<?php
namespace RealEstate\Core\Payment\Validation;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Numeric;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BankAccountValidator extends AbstractPaymentMethodValidator
{
       /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        parent::define($binder);

        $binder->bind('accountType', function(Property $property){
            $property
                ->addRule(new Obligate());
        });

        $binder->bind('routingNumber', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Length(9))
                ->addRule(new Numeric());
        });

        $binder->bind('accountNumber', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Length(5, 17))
                ->addRule(new Numeric());
        });

        $binder->bind('nameOnAccount', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(0, 22));
        });

        $binder->bind('bankName', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(0, 50));
        });
    }
}