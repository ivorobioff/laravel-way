<?php
namespace RealEstate\Core\Assignee\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\ReadOnly;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateFeeValidator extends AbstractFeeValidator
{
    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('jobType', function(Property $property){
            $property
                ->addRule(new ReadOnly());
        });

        $this->defineAmount($binder);
    }

    /**
     * @param array|object $source
     * @param bool $soft
     */
    public function validate($source, $soft = false)
    {
        parent::validate($source, true);
    }
}
