<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\CustomersProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\CustomerTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomersController extends BaseController
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @param CustomerService $customerService
	 */
	public function initialize(CustomerService $customerService)
	{
		$this->customerService = $customerService;
	}

	/**
	 * @param CustomersProcessor $processor
	 * @return Response
	 */
	public function store(CustomersProcessor $processor)
	{
		return $this->resource->make(
			$this->customerService->create($processor->createPersistable()),
			$this->transformer(CustomerTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @return Response
	 */
	public function show($customerId)
	{
		return $this->resource->make(
			$this->customerService->get($customerId),
			$this->transformer(CustomerTransformer::class)
		);
	}

	public function update($customerId, CustomersProcessor $processor)
	{
		$this->customerService->update(
			$customerId, 
			$processor->createPersistable(), 
			$processor->schedulePropertiesToClear()
		);

		return $this->resource->blank();
	}

	/**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @return bool
	 */
	public static function verifyAction(CustomerService $customerService, $customerId)
	{
		return $customerService->exists($customerId);
	}
}