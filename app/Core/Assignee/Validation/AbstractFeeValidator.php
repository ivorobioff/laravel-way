<?php
namespace RealEstate\Core\Assignee\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractFeeValidator extends AbstractThrowableValidator
{
    /**
     * @param Binder $binder
     */
    protected function defineAmount(Binder $binder)
    {
        $binder->bind('amount', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Greater(0));
        });
    }
}
