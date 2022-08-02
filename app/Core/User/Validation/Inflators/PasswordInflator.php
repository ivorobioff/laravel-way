<?php
namespace RealEstate\Core\User\Validation\Inflators;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\User\Validation\Rules\Password;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PasswordInflator
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @param EnvironmentInterface $environment
     */
    public function __construct(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param Property $property
     */
    public function __invoke(Property $property)
    {
        $property->addRule(new Obligate());

        if (!$this->environment->isRelaxed()){
            $property->addRule(new Password());
        } else {
            $property->addRule(new Blank());
        }
    }
}