<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\OrdersSearchableProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\CountersTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Appraisal\Enums\Queue;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Services\QueueService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
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
     * @param OrdersSearchableProcessor $processor
     * @param int $amcId
     * @param string $name
     * @return Response
     */
    public function index(OrdersSearchableProcessor $processor, $amcId, $name)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($amcId, $name, $processor){
                $options = new FetchOrdersOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());
                return $this->queueService->getAllByAssigneeId($amcId, new Queue($name), $options);
            },
            'getTotal' => function() use ($amcId, $name, $processor){
                return $this->queueService->getTotalByAssigneeId($amcId, new Queue($name), $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(OrderTransformer::class)
        );
    }

    /**
     * @param int $amcId
     * @return Response
     */
    public function counters($amcId)
    {
        return $this->resource->make(
            $this->queueService->getCountersByAssigneeId($amcId),
            $this->transformer(CountersTransformer::class)
        );
    }

    /**
     * @param AmcService $amcService
     * @param int $amcId
     * @param string $name
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $amcId, $name = null)
    {
        if (!$amcService->exists($amcId)){
            return false;
        }

        if ($name === null){
            return true;
        }

        return Queue::has($name);
    }
}