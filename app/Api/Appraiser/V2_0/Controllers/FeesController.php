<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Assignee\V2_0\Transformers\TotalTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Appraiser\Services\FeeService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeesController extends BaseController
{
	/**
	 * @var FeeService
	 */
	private $feeService;

	/**
	 * @param FeeService $feeService
	 */
	public function initialize(FeeService $feeService)
	{
		$this->feeService = $feeService;
	}

	/**
	 * @param $appraiserId
	 * @return Response
	 */
	public function totals($appraiserId)
	{
		return $this->resource->makeAll(
			$this->feeService->getTotals($appraiserId), 
			$this->transformer(TotalTransformer::class)
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