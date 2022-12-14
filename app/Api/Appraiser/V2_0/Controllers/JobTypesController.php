<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\JobTypesSearchableProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\JobTypeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Options\FetchJobTypesOptions;
use RealEstate\Core\Customer\Services\JobTypeService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypesController extends BaseController
{
	/**
	 * @var JobTypeService
	 */
	private $jobTypeService;

	/**
	 * @param JobTypeService $jobTypeService
	 */
	public function initialize(JobTypeService $jobTypeService)
	{
		$this->jobTypeService = $jobTypeService;
	}

	/**
	 * @param int $appraiserId
	 * @param int $customerId
     * @param JobTypesSearchableProcessor $processor
	 * @return Response
	 */
	public function index($appraiserId, $customerId, JobTypesSearchableProcessor $processor)
	{
        $options = new FetchJobTypesOptions();
        $options->setCriteria($processor->getCriteria());

		return $this->resource->makeAll(
			$this->jobTypeService->getAllVisible($customerId, $options),
			$this->transformer(JobTypeTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @param int $customerId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId, $customerId)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		return $appraiserService->hasPendingInvitationFromCustomer($appraiserId, $customerId)
			|| $appraiserService->isRelatedWithCustomer($appraiserId, $customerId);
	}
}