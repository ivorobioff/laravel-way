<?php
namespace RealEstate\Api\Location\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Location\V2_0\Transformers\StateTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Services\ZipService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StatesController extends BaseController
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var ZipService
     */
    private $zipService;

    /**
     * @param StateService $stateService
     * @param ZipService $zipService
     */
    public function initialize(StateService $stateService, ZipService $zipService)
    {
        $this->stateService = $stateService;
        $this->zipService = $zipService;
    }

    /**
     * @param string $state
     * @return Response
     */
    public function zips($state)
    {
        return $this->resource->makeAll(['data' => $this->zipService->getAllInState($state)]);
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return $this->resource->makeAll(
            $this->stateService->getAll(),
            $this->transformer(StateTransformer::class)
        );
    }

    /**
     * @param StateService $stateService
     * @param string $state
     * @return Response
     */
    public static function verifyAction(StateService $stateService, $state)
    {
        return $stateService->exists($state);
    }
}