<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\FeesByCountyProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Amc\Services\CustomerFeeByCountyService;
use RealEstate\Core\Amc\Services\CustomerFeeService;
use RealEstate\Core\Location\Services\StateService;

class CustomerFeesByCountyController extends BaseController
{
    /**
     * @var CustomerFeeByCountyService
     */
    private $feeByCountyService;

    /**
     * @var CustomerFeeService
     */
    private $customerFeeService;

    /**
     * @param CustomerFeeByCountyService $feeByCountyService
     * @param CustomerFeeService $customerFeeService
     */
    public function initialize(CustomerFeeByCountyService $feeByCountyService, CustomerFeeService $customerFeeService)
    {
        $this->feeByCountyService = $feeByCountyService;
        $this->customerFeeService = $customerFeeService;
    }

    /**
     * @param int $amcId
     * @param int $customerId
     * @param int $jobTypeId
     * @param string $state
     * @return Response
     */
    public function index($amcId, $customerId, $jobTypeId, $state)
    {
        $fee = $this->customerFeeService->getByJobTypeId($amcId, $customerId, $jobTypeId);

        return $this->resource->makeAll(
            $this->feeByCountyService->getAllByStateCode($fee->getId(), $state),
            $this->transformer()
        );
    }

    /**
     * @param int $amcId
     * @param int $customerId
     * @param int $jobTypeId
     * @param string $state
     * @param FeesByCountyProcessor $processor
     * @return Response
     */
    public function sync($amcId, $customerId, $jobTypeId, $state, FeesByCountyProcessor $processor)
    {
        $fee = $this->customerFeeService->getByJobTypeId($amcId, $customerId, $jobTypeId);

        return $this->resource->makeAll(
            $this->feeByCountyService->syncInState($fee->getId(), $state, $processor->createPersistables()),
            $this->transformer()
        );
    }

    /**
     * @param AmcService $amcService
     * @param StateService $stateService
     * @param int $amcId
     * @param int $customerId
     * @param int $jobTypeId
     * @param string $state
     * @return bool
     */
    public static function verifyAction(
        AmcService $amcService,
        StateService $stateService,
        $amcId,
        $customerId,
        $jobTypeId,
        $state
    )
    {
        if (!$amcService->exists($amcId)) {
            return false;
        }

        if (!$amcService->isRelatedWithCustomer($amcId, $customerId)) {
            return false;
        }

        if (!$amcService->hasCustomerFeeWithJobType($amcId, $customerId, $jobTypeId)) {
            return false;
        }

        return $stateService->exists($state);
    }
}
