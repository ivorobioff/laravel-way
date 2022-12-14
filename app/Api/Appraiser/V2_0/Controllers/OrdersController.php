<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\ChangeAdditionalStatusProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\AdditionalStatusesTrait;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\ConditionsProcessor;
use RealEstate\Api\Assignee\V2_0\Processors\OrderDeclineProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\TotalsTransformer;
use RealEstate\Api\Assignee\V2_0\Processors\OrdersSearchableProcessor;
use RealEstate\Api\Company\V2_0\Controllers\CompanyOrdersTrait;
use RealEstate\Api\Company\V2_0\Processors\ReassignOrderProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalStatusTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Shared\Options\PaginationOptions;
use Restate\Libraries\Verifier\Action;

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
	 * @param int $appraiserId
	 * @param OrdersSearchableProcessor $processor
	 * @return Response
	 */
	public function index(OrdersSearchableProcessor $processor, $appraiserId)
	{
		$adapter = new DefaultPaginatorAdapter([
			'getAll' => function($page, $perPage) use ($appraiserId, $processor){
				$options = new FetchOrdersOptions();
				$options->setPagination(new PaginationOptions($page, $perPage));
				$options->setCriteria($processor->getCriteria());
				$options->setSortables($processor->createSortables());
				return $this->orderService->getAllByAssigneeId($appraiserId, $options);
			},
			'getTotal' => function() use ($appraiserId, $processor){
				return $this->orderService->getTotalByAssigneeId($appraiserId, $processor->getCriteria());
			}
		]);

		return $this->resource->makeAll(
			$this->paginator($adapter),
			$this->transformer(OrderTransformer::class)
		);
	}
	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function show($appraiserId, $orderId)
	{
		return $this->resource->make(
			$this->orderService->get($orderId),
			$this->transformer(OrderTransformer::class)
		);
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param ChangeAdditionalStatusProcessor $processor
	 * @return Response
	 */
	public function changeAdditionalStatus(
		ChangeAdditionalStatusProcessor $processor,
		$appraiserId,
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
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function accept($appraiserId, $orderId)
	{
		$this->orderService->accept($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param ConditionsProcessor $processor
	 * @return Response
	 */
	public function acceptWithConditions($appraiserId, $orderId, ConditionsProcessor $processor)
	{
		$this->orderService->acceptWithConditions($orderId, $processor->createConditions());

		return $this->resource->blank();
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param OrderDeclineProcessor $processor
	 * @return Response
	 */
	public function decline($appraiserId, $orderId, OrderDeclineProcessor $processor)
	{
		$this->orderService->decline(
			$orderId,
			$processor->getDeclineReason(),
			$processor->getDeclineMessage()
		);

		return $this->resource->blank();
	}

	/**
	 * @param OrdersSearchableProcessor $processor
	 * @param int $appraiserId
	 * @return Response
	 */
	public function totals(OrdersSearchableProcessor $processor, $appraiserId)
	{
		return $this->resource->make([
			'paid' => $this->orderService->getPaidTotalsByAssigneeId($appraiserId, $processor->getCriteria()),
			'unpaid' => $this->orderService->getUnpaidTotalsByAssigneeId($appraiserId, $processor->getCriteria())
		], $this->transformer(TotalsTransformer::class));
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function pay($appraiserId, $orderId)
	{
		$this->orderService->payTechFee($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function listAdditionalStatuses($appraiserId, $orderId)
	{
		return $this->resource->makeAll(
			$this->orderService->getAllActiveAdditionalStatuses($orderId),
			$this->transformer(AdditionalStatusTransformer::class)
		);
	}

    /**
     * @param int $appraiserId
     * @param int $orderId
     * @param ReassignOrderProcessor $processor
     * @return Response
     */
    public function reassign($appraiserId, $orderId, ReassignOrderProcessor $processor)
    {
        $this->validateOrderReassignment($appraiserId, $processor->getAppraiser(), $this->container);

        $this->orderService->reassign($orderId, $processor->getAppraiser());

        return $this->resource->blank();
    }

	/**
     * @param Action $action
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(Action $action, AppraiserService $appraiserService,  $appraiserId,  $orderId = null)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		if ($orderId === null){
			return true;
		}

		$withSubordinates = false;

        if ($action->is(['show', 'accept', 'decline', 'acceptWithConditions', 'reassign'])){
            $withSubordinates = true;
        }

		return $appraiserService->hasOrder($appraiserId, $orderId, $withSubordinates);
	}
}