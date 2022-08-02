<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;
use RealEstate\Core\Amc\Persistables\FeeByStatePersistable;
use RealEstate\Core\Location\Services\StateService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SyncFeesByStateValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @param StateService $stateService
     */
    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('data', function(Property $property){
            $property->addRule(new Walk(function(Binder $binder){

                $binder->bind('state', function(Property $property){
                     $property->addRule(new Obligate());
                });

                $binder->bind('amount', function(Property $property){
                    $property
                        ->addRule(new Obligate())
                        ->addRule(new Greater(0));
                });

            }));

            $property->addRule((
                new Callback([$this, 'uniqueStates']))
                    ->setMessage('The state must be unique in the current collection.')
                    ->setIdentifier('unique')
            );

            $property->addRule(
                (new Callback([$this, 'existStates']))
                    ->setMessage('One of the provided state does not exist in the system.')
                    ->setIdentifier('exists')
            );
        });
    }

    /**
     * @param FeeByStatePersistable[] $persistables
     * @return bool
     */
    public function uniqueStates(array $persistables)
    {
        $values = [];

        foreach ($persistables as $persistable){
            $values[$persistable->getState()] = true;
        }

        return count($persistables) === count($values);
    }

    /**
     * @param FeeByStatePersistable[] $persistables
     * @return bool
     */
    public function existStates(array $persistables)
    {
        return $this->stateService->existSelected(array_map(function(FeeByStatePersistable $persistable){
            return $persistable->getState();
        }, $persistables));
    }
}