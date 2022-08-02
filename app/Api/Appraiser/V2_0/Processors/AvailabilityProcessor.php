<?php
namespace RealEstate\Api\Appraiser\V2_0\Processors;

use RealEstate\Api\Appraiser\V2_0\Support\AvailabilityConfigurationTrait;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraiser\Persistables\AvailabilityPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AvailabilityProcessor extends BaseProcessor
{
	use AvailabilityConfigurationTrait;

	/**
	 * @return array
	 */
	protected function configuration()
	{
		return $this->getAvailabilityConfiguration();
	}

	/**
	 * @return AvailabilityPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new AvailabilityPersistable());
	}
}