<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\OrdersSearchableProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\CountersTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraisal\Enums\Queue;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Services\QueueService;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserQueuesController extends BaseController
{
    /**
     * @var QueueService
     */
    private $queueService;

    /**
     * @param QueueService $queueService
     */
    public function initialize(QueueService $queueService)
    {
        $this->queueService = $queueService;
    }

    /**
     * @param $customerId
     * @param int $appraiserId
     * @return Response
     */
    public function counters($customerId, $appraiserId)
    {
        return $this->resource->make(
            $this->queueService->getCountersByCustomerAndAssigneeId($customerId, $appraiserId),
            $this->transformer(CountersTransformer::class)
        );
    }

    /**
     * @param OrdersSearchableProcessor $processor
     * @param int $customerId
     * @param int $appraiserId
     * @param string $name
     * @return Response
     */
    public function index(OrdersSearchableProcessor $processor, $customerId, $appraiserId, $name)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($customerId, $appraiserId, $name, $processor){
                $options = new FetchOrdersOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());
                return $this->queueService->getAllByCustomerAndAssigneeIds($customerId, $appraiserId, new Queue($name), $options);
            },
            'getTotal' => function() use ($customerId, $appraiserId, $name, $processor){
                return $this->queueService->getTotalByCustomerAndAssigneeIds($customerId, $appraiserId, new Queue($name), $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(OrderTransformer::class)
        );
    }

    /**
     * @param CustomerService $customerService
     * @param AppraiserService $appraiserService
     * @param int $customerId
     * @param int $appraiserId
     * @return bool
     */
    public static function verifyAction(
        CustomerService $customerService,
        AppraiserService $appraiserService,
        $customerId,
        $appraiserId
    )
    {
        if (!$customerService->exists($customerId)){
            return false;
        }

        return $appraiserService->exists($appraiserId);
    }
}