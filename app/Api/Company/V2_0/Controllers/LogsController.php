<?php
namespace RealEstate\Api\Company\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Assignee\V2_0\Processors\LogsSearchableProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\LogTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Company\Services\ManagerService;
use RealEstate\Core\Log\Options\FetchLogsOptions;
use RealEstate\Core\Log\Services\LogService;
use RealEstate\Core\Shared\Options\PaginationOptions;

class LogsController extends BaseController
{
    /**
     * @var LogService
     */
    private $logService;

    /**
     * @param LogService $logService
     */
    public function initialize(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @param int $managerId
     * @param LogsSearchableProcessor $processor
     * @return Response
     */
    public function index($managerId, LogsSearchableProcessor $processor)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($managerId, $processor){
                $options = new FetchLogsOptions();
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());
                $options->setPagination(new PaginationOptions($page, $perPage));

                return $this->logService->getAllByAssigneeId($managerId, $options);
            },
            'getTotal' => function() use ($managerId, $processor){
                return $this->logService->getTotalByAssigneeId($managerId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll($this->paginator($adapter), $this->transformer(LogTransformer::class));
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param LogsSearchableProcessor $processor
     * @return Response
     */
    public function indexByOrder($managerId, $orderId, LogsSearchableProcessor $processor)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($orderId, $processor){
                $options = new FetchLogsOptions();
                $options->setCriteria($processor->getCriteria());
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setSortables($processor->createSortables());

                return $this->logService->getAllByOrderId($orderId, $options);
            },
            'getTotal' => function() use ($orderId, $processor){
                return $this->logService->getTotalByOrderId($orderId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll($this->paginator($adapter), $this->transformer(LogTransformer::class));
    }

    /**
     * @param ManagerService $managerService
     * @param int $managerId
     * @param int $orderId
     * @return bool
     */
    public static function verifyAction(ManagerService $managerService, $managerId, $orderId = null)
    {
        if (! $managerService->exists($managerId)) {
            return false;
        }

        if ($orderId && ! $managerService->hasOrder($managerId, $orderId)) {
            return false;
        }

        return true;
    }
}
