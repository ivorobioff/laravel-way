<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Amc\Persistables\SettingsPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'pushUrl' => 'string'
        ];
    }

    /**
     * @return SettingsPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new SettingsPersistable());
    }
}