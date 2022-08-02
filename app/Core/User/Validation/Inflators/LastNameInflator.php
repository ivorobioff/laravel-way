<?php
namespace RealEstate\Core\User\Validation\Inflators;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LastNameInflator
{
    public function __invoke(Property $property)
    {
        $property
            ->addRule(new Obligate())
            ->addRule(new Blank())
            ->addRule(new Length(1, 50));
    }
}