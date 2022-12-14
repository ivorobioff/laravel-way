<?php
namespace RealEstate\Api\Location\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Location\V2_0\Processors\CountiesProcessor;
use RealEstate\Api\Location\V2_0\Transformers\CountyTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Location\Services\CountyService;
use RealEstate\Core\Location\Services\StateService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountiesController extends BaseController
{
	/**
	 * @var CountyService
	 */
	private $countyService;

	/**
	 * @param CountyService $countyService
	 */
	public function initialize(CountyService $countyService)
	{
		$this->countyService = $countyService;
	}

	/**
	 * @param string $state
	 * @param CountiesProcessor $processor
	 * @return Response
	 */
	public function index($state, CountiesProcessor $processor)
	{
		return $this->resource->makeAll(
			$this->countyService->getAllInState($state, $processor->getSelectedCounties()),
			$this->transformer(CountyTransformer::class)
		);
	}

	/**
	 * @param string $state
	 * @param int $county
	 * @return Response
	 */
	public function show($state, $county)
	{
		return $this->resource->make(
			$this->countyService->get($county),
			$this->transformer(CountyTransformer::class)
		);
	}

	/**
	 * @param  StateService $stateService
	 * @param string $state
	 * @param int $county
	 * @return bool
	 */
	public static function verifyAction(StateService $stateService, $state, $county = null)
	{
		if (!$stateService->exists($state)){
			return false;
		}

		if ($county === null){
			return true;
		}

		return $stateService->hasCounty($state, $county);
	}
}