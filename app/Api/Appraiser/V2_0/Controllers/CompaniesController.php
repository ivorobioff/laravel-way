<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Company\V2_0\Transformers\CompanyTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Company\Services\CompanyService;

class CompaniesController extends BaseController
{
    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @param CompanyService $companyService
     */
    public function initialize(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * @param int $appraiserId
     * @return Response
     */
    public function index($appraiserId)
    {
        $companies = $this->companyService->getAllByAppraiserId($appraiserId);

        return $this->resource->makeAll($companies, $this->transformer(CompanyTransformer::class));
    }

    /**
     * @param AppraiserService $appraiserService
     * @param int $appraiserId
     * @return bool
     */
    public static function verifyAction(AppraiserService $appraiserService, $appraiserId) {
        return $appraiserService->exists($appraiserId);
    }
}