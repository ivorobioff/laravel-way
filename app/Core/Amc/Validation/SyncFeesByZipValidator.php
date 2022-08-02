<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;
use RealEstate\Core\Amc\Persistables\FeeByZipPersistable;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Services\ZipService;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SyncFeesByZipValidator extends AbstractThrowableValidator
{
    /**
     * @var State $state
     */
    private $state;

    /**
     * @var ZipService
     */
    private $zipService;

    /**
     * @param ContainerInterface $container
     * @param State $state
     */
    public function __construct(ContainerInterface $container, State $state)
    {
        $this->zipService = $container->get(ZipService::class);
        $this->state = $state;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('data', function(Property $property){
            $property->addRule(new Walk(function(Binder $binder){

                $binder->bind('zip', function(Property $property){
                    $property->addRule(new Obligate());
                });

                $binder->bind('amount', function(Property $property){
                    $property
                        ->addRule(new Obligate())
                        ->addRule(new Greater(0));
                });

            }));

            $property->addRule((new Callback([$this, 'uniqueZips']))
                ->setIdentifier('unique')
                ->setMessage('The provided zip codes should be unique in the scope of the current collection.'));

            $property->addRule((new Callback([$this, 'existZips']))
                ->setIdentifier('exists')
                ->setMessage('One of the provided zip code does not exist within the provided state.'));
        });
    }

    /**
     * @param FeeByZipPersistable[] $persistables
     * @return bool
     */
    public function uniqueZips(array $persistables)
    {
        $values = [];

        foreach ($persistables as $persistable){
            $values[$persistable->getZip()] = true;
        }

        return count($persistables) === count($values);
    }

    /**
     * @param FeeByZipPersistable[] $persistables
     * @return bool
     */
    public function existZips(array $persistables)
    {
        return $this->zipService->existSelectedInState(
            array_map(function(FeeByZipPersistable $persistable){ return $persistable->getZip(); }, $persistables),
            $this->state->getCode()
        );
    }
}