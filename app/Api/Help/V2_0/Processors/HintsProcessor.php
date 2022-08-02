<?php
namespace RealEstate\Api\Help\V2_0\Processors;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;
use RealEstate\Api\Support\BaseProcessor;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class HintsProcessor extends BaseProcessor
{
    /**
     * @param Binder $binder
     */
    protected function rules(Binder $binder)
    {
        $binder->bind('email', function(Property $property){
            $property
                ->addRule(new StringCast())
                ->addRule(new Blank())
                ->addRule(new Obligate());
        });
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->get('email');
    }
}