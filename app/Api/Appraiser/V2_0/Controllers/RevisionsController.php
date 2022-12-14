<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\RevisionTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\RevisionService;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RevisionsController extends BaseController
{
	/**
	 * @var RevisionService
	 */
	private $revisionService;

	/**
	 * @param RevisionService $revisionService
	 */
	public function initialize(RevisionService  $revisionService)
	{
		$this->revisionService = $revisionService;
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function index($appraiserId, $orderId)
	{
		return $this->resource->makeAll(
			$this->revisionService->getAll($orderId),
			$this->transformer(RevisionTransformer::class)
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