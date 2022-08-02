<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\CustomersSearchableProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalDocumentTypeTransformer;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalStatusTransformer;
use RealEstate\Api\Customer\V2_0\Transformers\CustomerTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Customer\Options\FetchCustomerOptions;
use RealEstate\Core\Customer\Services\AdditionalDocumentTypeService;
use RealEstate\Core\Customer\Services\AdditionalStatusService;
use RealEstate\Core\Customer\Services\CustomerService;

class CustomersController extends BaseController
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @param CustomerService $customerService
     */
    public function initialize(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @param int $amcId
     * @param CustomersSearchableProcessor $processor
     * @return Response
     */
    public function index($amcId, CustomersSearchableProcessor $processor)
    {
        $options = new FetchCustomerOptions();

        $options->setSortables($processor->createSortables());

        return $this->resource->makeAll(
            $this->customerService->getAllByAmcId($amcId, $options),
            $this->transformer(CustomerTransformer::class)
        );
    }

    /**
     * @param int $amcId
     * @param int $customerId
     * @return Response
     */
    public function listAdditionalStatuses($amcId, $customerId, AdditionalStatusService $service)
    {
        return $this->resource->makeAll(
            $service->getAllActive($customerId),
            $this->transformer(AdditionalStatusTransformer::class)
        );
    }

    /**
     * @param int $amcId
     * @param int $customerId
     * @return Response
     */
    public function listAdditionalDocumentsTypes($amcId, $customerId, AdditionalDocumentTypeService $service)
    {
        return $this->resource->makeAll(
            $service->getAll($customerId),
            $this->transformer(AdditionalDocumentTypeTransformer::class)
        );
    }

    /**
     * @param AmcService $amcService
     * @param int $amcId
     * @param int $customerId
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $amcId, $customerId = null)
    {
        if (!$amcService->exists($amcId)) {
            return false;
        }

        if ($customerId && !$amcService->isRelatedWithCustomer($amcId, $customerId)) {
            return false;
        }

        return true;
    }
}
