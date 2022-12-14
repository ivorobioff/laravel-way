<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Assignee\V2_0\Processors\LogsSearchableProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\LogTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Log\Options\FetchLogsOptions;
use RealEstate\Core\Log\Services\LogService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
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
	 * @param int $appraiserId
	 * @param LogsSearchableProcessor $processor
	 * @return Response
	 */
	public function index($appraiserId, LogsSearchableProcessor $processor)
	{
		$adapter = new DefaultPaginatorAdapter([
			'getAll' => function($page, $perPage) use ($appraiserId, $processor){
				$options = new FetchLogsOptions();
				$options->setCriteria($processor->getCriteria());
				$options->setSortables($processor->createSortables());
				$options->setPagination(new PaginationOptions($page, $perPage));

				return $this->logService->getAllByAssigneeId($appraiserId, $options);
			},
			'getTotal' => function() use ($appraiserId, $processor){
				return $this->logService->getTotalByAssigneeId($appraiserId, $processor->getCriteria());
			}
		]);

		return $this->resource->makeAll($this->paginator($adapter), $this->transformer(LogTransformer::class));
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param LogsSearchableProcessor $processor
	 * @return Response
	 */
	public function indexByOrder($appraiserId, $orderId, LogsSearchableProcessor $processor)
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
	 * @param AppraiserService $appraiserService
	 * @param $appraiserId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId, $orderId = null)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		if ($orderId === null){
			return true;
		}

		return $appraiserService->hasOrder($appraiserId, $orderId, true);
	}
}