<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\ReconsiderationTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\ReconsiderationService;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationsController extends BaseController
{
	/**
	 * @var ReconsiderationService
	 */
	private $reconsiderationService;

	/**
	 * @param ReconsiderationService $reconsiderationService
	 */
	public function initialize(ReconsiderationService $reconsiderationService)
	{
		$this->reconsiderationService = $reconsiderationService;
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function index($appraiserId, $orderId)
	{
		return $this->resource->makeAll(
			$this->reconsiderationService->getAll($orderId),
			$this->transformer(ReconsiderationTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId, $orderId)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		return $appraiserService->hasOrder($appraiserId, $orderId);
	}
}