<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Restate\Libraries\Kangaroo\Response\ResponseFactoryInterface;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\ChangeAdditionalStatusProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\AdditionalStatusesTrait;
use RealEstate\Api\Customer\V2_0\Processors\AwardOrderProcessor;
use RealEstate\Api\Customer\V2_0\Processors\OrdersProcessor;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Customer\V2_0\Processors\PayoffProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Exceptions\WalletTransactionException;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersController extends BaseController
{
	use AdditionalStatusesTrait;

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
	 * @param int $customerId
	 * @param int $orderId
	 * @param ChangeAdditionalStatusProcessor $processor
	 * @return Response
	 */
	public function changeAdditionalStatus(
		ChangeAdditionalStatusProcessor $processor,
		$customerId,
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
	 * @param int $customerId
	 * @param int $orderId
	 * @param OrdersProcessor $processor
	 * @return Response
	 */
	public function update($customerId, $orderId, OrdersProcessor $processor)
	{
		$this->orderService->update($orderId, $processor->createPersistable(), $processor->schedulePropertiesToClear());

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param AwardOrderProcessor $processor
	 * @return Response
	 */
	public function award($customerId, $orderId, AwardOrderProcessor $processor)
	{
		$this->orderService->award($orderId, $processor->getAssignedAt());

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function show($customerId, $orderId)
	{
		return $this->resource->make(
			$this->orderService->get($orderId),
			$this->transformer(OrderTransformer::class)
		);
	}

	/**
	 * @param $customerId
	 * @param $orderId
	 * @return Response
	 */
	public function destroy($customerId, $orderId)
	{
		$this->orderService->delete($orderId);

		return $this->resource->blank();
	}

    /**
     * @param int $customerId
     * @param int $orderId
     * @param PayoffProcessor $processor
     * @return Response
     */
    public function payoff($customerId, $orderId, PayoffProcessor $processor)
    {
        try {
            $this->orderService->payoff($orderId, $processor->createPayoff());
        } catch (WalletTransactionException  $exception){
            /**
             * @var ResponseFactoryInterface $response
             */
            $response = $this->container->make(ResponseFactoryInterface::class);

            return $response->create([
                'code' => $exception->getErrorCode(),
                'message' => $exception->getMessage()
            ], 400);
        }

        return $this->resource->blank();
    }


    /**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(
		CustomerService $customerService,
		$customerId,
		$orderId
	)
	{
		if (!$customerService->exists($customerId)){
			return false;
		}

		return $customerService->hasOrder($customerId, $orderId);
	}
}