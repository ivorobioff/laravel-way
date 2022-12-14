<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\BidsProcessor;
use RealEstate\Api\Appraisal\V2_0\Transformers\BidTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\BidService;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidController extends BaseController
{
	/**
	 * @var BidService
	 */
	private $bidService;

	/**
	 * @var OrderService
	 */
	private $orderService;

	/**
	 * @param BidService $bidService
	 * @param OrderService $orderService
	 */
	public function initialize(BidService $bidService, OrderService $orderService)
	{
		$this->bidService = $bidService;
		$this->orderService = $orderService;
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param BidsProcessor $processor
	 * @return Response
	 */
	public function store($appraiserId, $orderId, BidsProcessor $processor)
	{
		return $this->resource->make(
			$this->bidService->create($orderId, $processor->createPersistable()),
			$this->transformer(BidTransformer::class)
		);
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function show($appraiserId, $orderId)
	{
		if (!$this->orderService->hasBid($orderId)){
			return $this->resource->error()->notFound();
		}

		return $this->resource->make(
			$this->bidService->get($orderId),
			$this->transformer(BidTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(
		AppraiserService $appraiserService,
		$appraiserId,
		$orderId = null
	)
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