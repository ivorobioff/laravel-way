<?php
namespace RealEstate\Api\Appraiser\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraiser\Persistables\LicensePersistable;
use RealEstate\Api\Appraiser\V2_0\Support\LicenseConfigurationTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicensesProcessor extends BaseProcessor
{
    use LicenseConfigurationTrait;

    /**
     * @return array
     */
    protected function configuration()
    {
        return $this->getLicenseConfiguration();
    }

    /**
     * @return LicensePersistable
     */
    public function createPersistable()
    {
        return $this->populate(new LicensePersistable(), $this->getPopulatorConfig());
    }
}