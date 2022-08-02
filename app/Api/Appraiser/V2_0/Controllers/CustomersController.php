<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\CustomersSearchableProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\CustomerTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Options\FetchCustomerOptions;
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
	 * @param int $appraiserId
	 * @param CustomersSearchableProcessor $processor
	 * @return Response
	 */
	public function index($appraiserId, CustomersSearchableProcessor $processor)
	{
		$options = new FetchCustomerOptions();

		$options->setSortables($processor->createSortables());

		return $this->resource->makeAll(
			$this->customerService->getAllByAppraiserId($appraiserId, $options),
			$this->transformer(CustomerTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId)
	{
		return $appraiserService->exists($appraiserId);
	}
}