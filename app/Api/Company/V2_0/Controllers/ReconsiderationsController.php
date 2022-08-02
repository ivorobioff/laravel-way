<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\ReconsiderationTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\ReconsiderationService;
use RealEstate\Core\Company\Services\ManagerService;

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
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function index($managerId, $orderId)
    {
        return $this->resource->makeAll(
            $this->reconsiderationService->getAll($orderId),
            $this->transformer(ReconsiderationTransformer::class)
        );
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