<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\OrdersSearchableProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\CountersTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraisal\Enums\Queue;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Services\QueueService;
use RealEstate\Core\Company\Services\ManagerService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class QueuesController extends BaseController
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
     * @param int $managerId
     * @return Response
     */
    public function counters($managerId)
    {
        return $this->resource->make(
            $this->queueService->getCountersByAssigneeId($managerId),
            $this->transformer(CountersTransformer::class)
        );
    }

    /**
     * @param OrdersSearchableProcessor $processor
     * @param int $managerId
     * @param string $name
     * @return Response
     */
    public function index(OrdersSearchableProcessor $processor, $managerId, $name)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($managerId, $name, $processor){
                $options = new FetchOrdersOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());
                return $this->queueService->getAllByAssigneeId($managerId, new Queue($name), $options);
            },
            'getTotal' => function() use ($managerId, $name, $processor){
                return $this->queueService->getTotalByAssigneeId($managerId, new Queue($name), $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(OrderTransformer::class)
        );
    }

    /**
     * @param ManagerService $managerService
     * @param int $managerId
     * @param string $name
     * @return bool
     */
    public static function verifyAction(ManagerService $managerService, $managerId, $name = null)
    {
        if (!$managerService->exists($managerId)){
            return false;
        }

        if ($name === null){
            return true;
        }

        return Queue::has($name);
    }
}