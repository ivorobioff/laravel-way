<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\ChangeAdditionalStatusProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\AdditionalStatusesTrait;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\ConditionsProcessor;
use RealEstate\Api\Assignee\V2_0\Processors\OrderDeclineProcessor;
use RealEstate\Api\Assignee\V2_0\Processors\OrdersSearchableProcessor;
use RealEstate\Api\Company\V2_0\Processors\ReassignOrderProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalStatusTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Company\Services\ManagerService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersController extends BaseController
{
    use AdditionalStatusesTrait;
    use CompanyOrdersTrait;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @param OrderService $orderService
     */
    public function initialize(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param int $managerId
     * @param OrdersSearchableProcessor $processor
     * @return Response
     */
    public function index(OrdersSearchableProcessor $processor, $managerId)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($managerId, $processor){
                $options = new FetchOrdersOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());
                return $this->orderService->getAllByAssigneeId($managerId, $options);
            },
            'getTotal' => function() use ($managerId, $processor){
                return $this->orderService->getTotalByAssigneeId($managerId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(OrderTransformer::class)
        );
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function show($managerId, $orderId)
    {
        return $this->resource->make(
            $this->orderService->get($orderId),
            $this->transformer(OrderTransformer::class)
        );
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function accept($managerId, $orderId)
    {
        $this->orderService->accept($orderId);

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param ConditionsProcessor $processor
     * @return Response
     */
    public function acceptWithConditions($managerId, $orderId, ConditionsProcessor $processor)
    {
        $this->orderService->acceptWithConditions($orderId, $processor->createConditions());

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param OrderDeclineProcessor $processor
     * @return Response
     */
    public function decline($managerId, $orderId, OrderDeclineProcessor $processor)
    {
        $this->orderService->decline(
            $orderId,
            $processor->getDeclineReason(),
            $processor->getDeclineMessage()
        );

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param ReassignOrderProcessor $processor
     * @return Response
     */
    public function reassign($managerId, $orderId, ReassignOrderProcessor $processor)
    {
        $this->validateOrderReassignment($managerId, $processor->getAppraiser(), $this->container);

        $this->orderService->reassign($orderId, $processor->getAppraiser());

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param ChangeAdditionalStatusProcessor $processor
     * @return Response
     */
    public function changeAdditionalStatus(
        ChangeAdditionalStatusProcessor $processor,
        $managerId,
        $orderId
    )
    {
        $this->tryChangeAdditionalStatus(function() use ($orderId, $processor){
            $this->orderService->changeAdditionalStatus(
                $orderId,
                $processor->getAdditionalStatus(),
                $processor->getComment()
            );
        });

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function listAdditionalStatuses($managerId, $orderId)
    {
        return $this->resource->makeAll(
            $this->orderService->getAllActiveAdditionalStatuses($orderId),
            $this->transformer(AdditionalStatusTransformer::class)
        );
    }

    /**
     * @param ManagerService $managerService
     * @param int $managerId
     * @param int  $orderId
     * @return bool
     */
    public static function verifyAction(ManagerService $managerService, $managerId, $orderId = null)
    {
        if (!$managerService->exists($managerId)){
            return false;
        }

        if ($orderId === null){
            return true;
        }

        return $managerService->hasOrder($managerId, $orderId);
    }
}