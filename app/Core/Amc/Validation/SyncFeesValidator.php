<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;
use RealEstate\Core\Assignee\Persistables\FeePersistable;
use RealEstate\Core\JobType\Services\JobTypeService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SyncFeesValidator extends AbstractThrowableValidator
{
    /**
     * @var JobTypeService
     */
    private $jobTypesService;

    /**
     * @param JobTypeService $jobTypeService
     */
    public function __construct(JobTypeService $jobTypeService)
    {
        $this->jobTypesService = $jobTypeService;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('data', function(Property $property){

            $property->addRule(new Walk(function(Binder $binder){

                $binder->bind('jobType', function(Property $property){
                    $property->addRule(new Obligate());
                });

                $binder->bind('amount', function(Property $property){
                    $property->addRule(new Obligate());
                    $property->addRule(new Greater(0));
                });
            }));

            $property->addRule((new Callback([$this, 'uniqueJobTypes']))
                ->setMessage('The job types must be unique in the current collection.')
                ->setIdentifier('unique')
            );

            $property->addRule((new Callback([$this, 'existJobTypes']))
                ->setMessage('One of the provided job types does not exist in the system.')
                ->setIdentifier('exists')
            );
        });
    }

    /**
     * @param FeePersistable[] $persistables
     * @return bool
     */
    public function uniqueJobTypes(array $persistables)
    {
        $values = [];

        foreach ($persistables as $persistable){
            $values[$persistable->getJobType()] = true;
        }

        return count($persistables) === count($values);
    }

    /**
     * @param FeePersistable[] $persistables
     * @return bool
     */
    public function existJobTypes(array $persistables)
    {
        return $this->jobTypesService->existSelected(array_map(function(FeePersistable $persistable){
            return $persistable->getJobType();
        }, $persistables));
    }
}