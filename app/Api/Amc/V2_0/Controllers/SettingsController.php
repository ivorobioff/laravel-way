<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\SettingsProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Amc\Services\SettingsService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsController extends BaseController
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function initialize(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param int $amcId
     * @return Response
     */
    public function show($amcId)
    {
        return $this->resource->make($this->settingsService->get($amcId), $this->transformer());
    }

    /**
     * @param int $amcId
     * @param SettingsProcessor $processor
     * @return Response
     */
    public function update($amcId, SettingsProcessor $processor)
    {
        $this->settingsService->update(
            $amcId,
            $processor->createPersistable(),
            $processor->schedulePropertiesToClear()
        );

        return $this->resource->blank();
    }

    /**
     * @param AmcService $amcService
     * @param int $amcId
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $amcId)
    {
        return $amcService->exists($amcId);
    }
}