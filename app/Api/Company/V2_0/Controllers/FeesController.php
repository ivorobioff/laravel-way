<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Company\V2_0\Processors\FeesProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Services\FeeService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeesController extends BaseController
{
    /**
     * @var FeeService
     */
    private $feeService;

    /**
     * @param FeeService $feeService
     */
    public function initialize(FeeService $feeService)
    {
        $this->feeService = $feeService;
    }

    /**
     * @param int $companyId
     * @return Response
     */
    public function index($companyId)
    {
        return $this->resource->makeAll($this->feeService->getAll($companyId), $this->transformer());
    }

    /**
     * @param int $companyId
     * @param FeesProcessor $processor
     * @return Response
     */
    public function replace($companyId, FeesProcessor $processor)
    {
        $this->feeService->sync($companyId, $processor->createPersistables());

        return $this->resource->blank();
    }

    /**
     * @param CompanyService $companyService
     * @param int $companyId
     * @return bool
     */
    public static function verifyAction(CompanyService $companyService, $companyId)
    {
        return $companyService->exists($companyId);
    }
}