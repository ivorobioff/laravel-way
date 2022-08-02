<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\OrdersProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Options\CreateOrderOptions;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CompaniesController extends BaseController
{
    /**
     * @param int $customerId
     * @param int $companyId
     * @param int $staffId
     * @param OrdersProcessor $processor
     * @return Response
     */
    public function storeOrder($customerId, $companyId, $staffId, OrdersProcessor $processor)
    {
        $options = new CreateOrderOptions();
        $options->setFromStaff(true);

        /**
         * @var OrderService $orderService
         */
        $orderService = $this->container->make(OrderService::class);

        return $this->resource->make(
            $orderService->create($customerId, $staffId, $processor->createPersistable(), $options),
            $this->transformer()
        );
    }

    /**
     * @param CustomerService $customerService
     * @param CompanyService $companyService
     * @param int $customerId
     * @param int $companyId
     * @param int $staffId
     * @return bool
     */
    public static function verifyAction(
        CustomerService $customerService,
        CompanyService $companyService,
        $customerId,
        $companyId,
        $staffId
    )
    {
        if (!$customerService->exists($customerId)){
            return false;
        }

        if (!$companyService->exists($companyId)){
            return false;
        }

        return $companyService->hasStaff($companyId, $staffId);
    }
}