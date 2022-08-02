<?php
namespace RealEstate\Api\JobType\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\JobType\V2_0\Transformers\JobTypeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\JobType\Services\JobTypeService;

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
	 * @return Response
	 */
	public function index()
	{
		return $this->resource->makeAll(
			$this->jobTypeService->getAll(),
			$this->transformer(JobTypeTransformer::class)
		);
	}
}