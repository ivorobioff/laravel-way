<?php
namespace RealEstate\Core\Customer\Validation\Inflators;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Length;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientAddressInflator
{
    /**
     * @param Property $property
     */
    public function __invoke(Property $property)
    {
        $property->addRule(new Length(0, 255));
    }
}