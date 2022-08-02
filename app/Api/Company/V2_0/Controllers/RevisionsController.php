<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Transformers\RevisionTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\RevisionService;
use RealEstate\Core\Company\Services\ManagerService;

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
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function index($managerId, $orderId)
    {
        return $this->resource->makeAll(
            $this->revisionService->getAll($orderId),
            $this->transformer(RevisionTransformer::class)
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