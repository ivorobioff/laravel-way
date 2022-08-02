<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\FeesByCountyProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Amc\Services\FeeByCountyService;
use RealEstate\Core\Amc\Services\FeeService;
use RealEstate\Core\Location\Services\StateService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByCountyController extends BaseController
{
    /**
     * @var FeeByCountyService
     */
    private $feeByCountyService;

    /**
     * @var FeeService
     */
    private $feeService;

    /**
     * @param FeeByCountyService $feeByCountyService
     * @param FeeService $feeService
     */
    public function initialize(FeeByCountyService $feeByCountyService, FeeService $feeService)
    {
        $this->feeByCountyService = $feeByCountyService;
        $this->feeService = $feeService;
    }

    /**
     * @param int $amcId
     * @param int $jobTypeId
     * @param string $stateCode
     * @return Response
     */
    public function index($amcId, $jobTypeId, $stateCode)
    {
        $fee = $this->feeService->getByJobTypeId($amcId, $jobTypeId);

        return $this->resource->makeAll(
            $this->feeByCountyService->getAllByStateCode($fee->getId(), $stateCode),
            $this->transformer()
        );
    }

    /**
     * @param int $amcId
     * @param int $jobTypeId
     * @param int $stateCode
     * @param FeesByCountyProcessor $processor
     * @return Response
     */
    public function sync($amcId, $jobTypeId, $stateCode, FeesByCountyProcessor $processor)
    {
        $fee = $this->feeService->getByJobTypeId($amcId, $jobTypeId);

        return $this->resource->makeAll(
            $this->feeByCountyService->syncInState($fee->getId(), $stateCode, $processor->createPersistables()),
            $this->transformer()
        );
    }

    /**
     * @param AmcService $amcService
     * @param StateService $stateService
     * @param int $amcId
     * @param int $jobTypeId
     * @param int $stateCode
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, StateService $stateService, $amcId, $jobTypeId, $stateCode)
    {
        if (!$amcService->exists($amcId)){
            return false;
        }

        if (!$amcService->hasEnabledFeeByJobTypeId($amcId, $jobTypeId)){
            return false;
        }

        return $stateService->exists($stateCode);
    }
}