<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Assignee\V2_0\Transformers\CustomerFeeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\CustomerFeeService;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeesController extends BaseController
{
	/**
	 * @var CustomerFeeService
	 */
	private $feeService;

	/**
	 * @param CustomerFeeService $feeService
	 */
	public function initialize(CustomerFeeService $feeService)
	{
		$this->feeService = $feeService;
	}

	/**
	 * @param $customerId
	 * @param $appraiserId
	 * @return Response
	 */
	public function index($customerId, $appraiserId)
	{
		return $this->resource->makeAll(
			$this->feeService->getAll($appraiserId, $customerId),
			$this->transformer(CustomerFeeTransformer::class)
		);
	}

	/**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @param int $appraiserId
	 * @return bool
	 */
	public static function verifyAction(CustomerService $customerService, $customerId, $appraiserId)
	{
		return $customerService->exists($customerId)
			&& $customerService->isRelatedWithAppraiser($customerId, $appraiserId);
	}
}