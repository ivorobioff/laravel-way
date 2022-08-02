<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\CompleteInspectionProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\ScheduleInspectionProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\InspectionService;
use RealEstate\Core\Company\Services\ManagerService;

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
     * @param int $managerId
     * @param int $orderId
     * @param ScheduleInspectionProcessor $processor
     * @return Response
     */
    public function schedule($managerId, $orderId, ScheduleInspectionProcessor $processor)
    {
        $this->inspectionService->schedule(
            $orderId,
            $processor->getScheduledAt(),
            $processor->getEstimatedCompletionDate()
        );

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param CompleteInspectionProcessor $processor
     * @return Response
     */
    public function complete($managerId, $orderId, CompleteInspectionProcessor $processor)
    {
        $this->inspectionService->complete(
            $orderId,
            $processor->getCompletedAt(),
            $processor->getEstimatedCompletionDate()
        );

        return $this->resource->blank();
    }

    /**
     * @param ManagerService $managerService
     * @param int $managerId
     * @param int $orderId
     * @return bool
     */
    public static function verifyAction(ManagerService $managerService, $managerId, $orderId)
    {
        if (!$managerService->exists($managerId)){
            return false;
        }

        return $managerService->hasOrder($managerId, $orderId);
    }
}