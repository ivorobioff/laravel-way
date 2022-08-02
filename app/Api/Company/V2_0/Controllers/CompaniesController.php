<?php
namespace RealEstate\Api\Company\V2_0\Controllers;

use Restate\Libraries\Verifier\Action;
use Illuminate\Http\Response;
use RealEstate\Api\Company\V2_0\Processors\CompaniesProcessor;
use RealEstate\Api\Company\V2_0\Transformers\CompanyTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Session\Entities\Session;

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
     * @param string $taxId
     * @return Response
     */
    public function showByTaxId($taxId)
    {
        return $this->resource->make(
            $this->companyService->getByTaxId($taxId),
            $this->transformer(CompanyTransformer::class)
        );
    }

    /**
     * @param CompaniesProcessor $processor
     * @return Response
     */
    public function store(CompaniesProcessor $processor)
    {
        $session = $this->container->make(Session::class);

        $company = $this->companyService->create(
            $session->getUser()->getId(),
            $processor->createPersistable()
        );

        return $this->resource->make($company, $this->transformer(CompanyTransformer::class));
    }

    /**
     * @param CompaniesProcessor $processor
     * @param int $companyId
     * @return Response
     */
    public function update(CompaniesProcessor $processor, $companyId)
    {
        $this->companyService->update($companyId, $processor->createPersistable());

        return $this->resource->blank();
    }

    /**
     * @param Action $action
     * @param CompanyService $companyService
     * @param string $companyIdOrTaxId
     * @return bool
     */
    public static function verifyAction(Action $action, CompanyService $companyService, $companyIdOrTaxId = null)
    {
        if ($action->is('showByTaxId')) {
            if (! $companyIdOrTaxId) {
                return false;
            }

            return $companyService->existsWithTaxId($companyIdOrTaxId);
        }

        if ($companyIdOrTaxId) {
            return $companyService->exists($companyIdOrTaxId);
        }

        return true;
    }
}
