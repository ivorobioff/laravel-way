<?php
namespace RealEstate\Core\Customer\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Validation\Rules\AllowedRulesInRuleset;
use RealEstate\Core\Customer\Validation\Rules\RuleValuesCast;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesetValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->stateService = $container->get(StateService::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('level', function(Property $property){
            $property->addRule(new Obligate());
        });

        $binder->bind('label', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('rules', function(Property $property){
            $property
                ->addRule(new AllowedRulesInRuleset());

            $property
                ->addRule(new RuleValuesCast($this->stateService));
        });
    }
}