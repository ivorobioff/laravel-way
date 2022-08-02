<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\CompleteInspectionProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\ScheduleInspectionProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\InspectionService;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InspectionController extends BaseController
{
	/**
	 * @var InspectionService
	 */
	private $inspectionService;

	/**
	 * @param InspectionService $inspectionService
	 */
	public function initialize(InspectionService $inspectionService)
	{
		$this->inspectionService = $inspectionService;
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param ScheduleInspectionProcessor $processor
	 * @return Response
	 */
	public function schedule($appraiserId, $orderId, ScheduleInspectionProcessor $processor)
	{
		$this->inspectionService->schedule(
			$orderId,
			$processor->getScheduledAt(),
			$processor->getEstimatedCompletionDate()
		);

		return $this->resource->blank();
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param CompleteInspectionProcessor $processor
	 * @return Response
	 */
	public function complete($appraiserId, $orderId, CompleteInspectionProcessor $processor)
	{
		$this->inspectionService->complete(
			$orderId,
			$processor->getCompletedAt(),
			$processor->getEstimatedCompletionDate()
		);

		return $this->resource->blank();
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