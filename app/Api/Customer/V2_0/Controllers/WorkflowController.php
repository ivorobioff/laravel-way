<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\CompleteInspectionProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\ScheduleInspectionProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\PostponeProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Appraisal\Options\InspectionOptions;
use RealEstate\Core\Appraisal\Services\WorkflowService;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Letter\Support\Notifier;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class WorkflowController extends BaseController
{
	/**
	 * @var WorkflowService
	 */
	private $workflowService;

	/**
	 * @param WorkflowService $workflowService
	 */
	public function initialize(WorkflowService $workflowService)
	{
		$this->workflowService = $workflowService;
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function fresh($customerId, $orderId)
	{
		$this->workflowService->fresh($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function requestForBid($customerId, $orderId)
	{
		$this->workflowService->requestForBid($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function accepted($customerId, $orderId)
	{
		$this->workflowService->accepted($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param ScheduleInspectionProcessor $processor
	 * @return Response
	 */
	public function inspectionScheduled($customerId, $orderId, ScheduleInspectionProcessor $processor)
	{
        $options = new InspectionOptions();
        $options->setBypassDatesValidation(true);

		$this->workflowService->inspectionScheduled(
			$orderId,
			$processor->getScheduledAt(),
			$processor->getEstimatedCompletionDate(),
            $options
		);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param CompleteInspectionProcessor $processor
	 * @return Response
	 */
	public function inspectionCompleted($customerId, $orderId, CompleteInspectionProcessor $processor)
	{
        $options = new InspectionOptions();
        $options->setBypassDatesValidation(true);

		$this->workflowService->inspectionCompleted(
			$orderId,
			$processor->getCompletedAt(),
			$processor->getEstimatedCompletionDate(),
            $options
		);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function readyForReview($customerId, $orderId)
	{
		$this->workflowService->readyForReview($orderId);
		
		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function late($customerId, $orderId)
	{
		$this->workflowService->late($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param PostponeProcessor $processor
	 * @return Response
	 */
	public function onHold($customerId, $orderId, PostponeProcessor $processor)
	{
		$this->container->resolving(function(Notifier $notifier) use ($processor) {
			$notifier->addFilter(function($notification) use ($processor){
				if ($notification instanceof SendMessageNotification){
					return null;
				}

				if ($notification instanceof UpdateProcessStatusNotification
						&& $processor->notifyAppraiser() === false){
					return null;
				}

				return $notification;
			});
		});

		$this->workflowService->onHold($orderId, $processor->getExplanation());

		return $this->resource->blank();
	}


	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function revisionPending($customerId, $orderId)
	{
		$this->workflowService->revisionPending($orderId);
		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function revisionInReview($customerId, $orderId)
	{
		$this->workflowService->revisionInReview($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function reviewed($customerId, $orderId)
	{
		$this->workflowService->reviewed($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function completed($customerId, $orderId)
	{
		$this->workflowService->completed($orderId);

		return $this->resource->blank();
	}

	/**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @param int $orderId
	 * @return bool
	 */
	public static function verifyAction(CustomerService $customerService, $customerId, $orderId)
	{
		if (!$customerService->exists($customerId)){
			return false;
		}

		return $customerService->hasOrder($customerId, $orderId);
	}
}