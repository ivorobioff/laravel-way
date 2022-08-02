<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\JobTypesSearchableProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\JobTypeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Customer\Options\FetchJobTypesOptions;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Customer\Services\JobTypeService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class JobTypesController extends BaseController
{
    /**
     * @var JobTypeService
     */
    private $jobTypeService;

    /**
     * @param JobTypeService $jobTypeService
     */
    public function initialize(JobTypeService $jobTypeService)
    {
        $this->jobTypeService = $jobTypeService;
    }

    /**
     * @param int $amcId
     * @param int $customerId
     * @param JobTypesSearchableProcessor $processor
     * @return Response
     */
    public function index($amcId, $customerId, JobTypesSearchableProcessor $processor)
    {
        $options = new FetchJobTypesOptions();
        $options->setCriteria($processor->getCriteria());

        return $this->resource->makeAll(
            $this->jobTypeService->getAllVisible($customerId, $options),
            $this->transformer(JobTypeTransformer::class)
        );
    }

    /**
     * @param AmcService $amcService
     * @param CustomerService $customerService
     * @param int $amcId
     * @param int $customerId
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, CustomerService $customerService, $amcId, $customerId)
    {
        if (!$amcService->exists($amcId)){
            return false;
        }

        return $customerService->isRelatedWithAmc($customerId, $amcId);
    }
}