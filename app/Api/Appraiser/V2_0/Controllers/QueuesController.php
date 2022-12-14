<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

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
	 * @param int $appraiserId
	 * @return Response
	 */
	public function counters($appraiserId)
	{
		return $this->resource->make(
			$this->queueService->getCountersByAssigneeId($appraiserId),
			$this->transformer(CountersTransformer::class)
		);
	}

	/**
	 * @param OrdersSearchableProcessor $processor
	 * @param int $appraiserId
	 * @param string $name
	 * @return Response
	 */
	public function index(OrdersSearchableProcessor $processor, $appraiserId, $name)
	{
		$adapter = new DefaultPaginatorAdapter([
			'getAll' => function($page, $perPage) use ($appraiserId, $name, $processor){
				$options = new FetchOrdersOptions();
				$options->setPagination(new PaginationOptions($page, $perPage));
				$options->setCriteria($processor->getCriteria());
				$options->setSortables($processor->createSortables());
				return $this->queueService->getAllByAssigneeId($appraiserId, new Queue($name), $options);
			},
			'getTotal' => function() use ($appraiserId, $name, $processor){
				return $this->queueService->getTotalByAssigneeId($appraiserId, new Queue($name), $processor->getCriteria());
			}
		]);

		return $this->resource->makeAll(
			$this->paginator($adapter),
			$this->transformer(OrderTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @param string $name
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId, $name = null)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		if ($name === null){
			return true;
		}

		return Queue::has($name);
	}
}