<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;
use RealEstate\Core\Amc\Persistables\FeeByCountyPersistable;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Services\CountyService;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SyncFeesByCountyValidator extends AbstractThrowableValidator
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var CountyService
     */
    private $countyService;

    /**
     * @param ContainerInterface $container
     * @param State $state
     */
    public function __construct(ContainerInterface $container, State $state)
    {
        $this->state = $state;
        $this->countyService = $container->get(CountyService::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('data', function(Property $property){
            $property->addRule(new Walk(function(Binder $binder){

                $binder->bind('county', function(Property $property){
                    $property->addRule(new Obligate());
                });

                $binder->bind('amount', function(Property $property){
                    $property
                        ->addRule(new Obligate())
                        ->addRule(new Greater(0));
                });

            }));

            $property->addRule((new Callback([$this, 'uniqueCounties']))
                ->setIdentifier('unique')
                ->setMessage('The provided counties should be unique in the scope of the current collection.'));

            $property->addRule((new Callback([$this, 'existCounties']))
                ->setIdentifier('exists')
                ->setMessage('One of the provided counties does not exist within the provided state.'));
        });
    }

    /**
     * @param FeeByCountyPersistable[] $persistables
     * @return bool
     */
    public function uniqueCounties(array $persistables)
    {
        $values = [];

        foreach ($persistables as $persistable){
            $values[$persistable->getCounty()] = true;
        }

        return count($persistables) === count($values);
    }

    /**
     * @param FeeByCountyPersistable[] $persistables
     * @return bool
     */
    public function existCounties(array $persistables)
    {
        return $this->countyService->existSelectedInState(
            array_map(function(FeeByCountyPersistable $persistable){ return $persistable->getCounty(); }, $persistables),
            $this->state->getCode()
        );
    }
}