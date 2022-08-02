<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsValidator extends AbstractThrowableValidator
{
    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('pushUrl', function(Property $property){
            $property
                ->addRule(new Blank());
        });
    }
}