<?php
namespace RealEstate\Api\Company\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Company\V2_0\Processors\ManagersProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Company\Services\ManagerService;

class ManagersController extends BaseController
{
    /**
     * @var ManagerService
     */
    private $managerService;

    /**
     * @param ManagerService $managerService
     */
    public function initialize(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    /**
     * @param int $managerId
     * @param ManagersProcessor $processor
     * @return Response
     */
    public function update($managerId, ManagersProcessor $processor)
    {
        $this->managerService->update(
            $managerId,
            $processor->createPersistable(),
            $processor->schedulePropertiesToClear()
        );

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @return Response
     */
    public function show($managerId)
    {
        return $this->resource->make($this->managerService->get($managerId), $this->transformer());
    }

    /**
     * @param ManagerService $managerService
     * @param int $managerId
     * @return bool
     */
    public static function verifyAction(ManagerService $managerService, $managerId)
    {
        return $managerService->exists($managerId);
    }
}
