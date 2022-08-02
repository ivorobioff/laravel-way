<?php
namespace RealEstate\Api\User\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\User\Enums\Platform;
use RealEstate\Core\User\Persistables\DevicePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DevicesProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'token' => 'string',
			'platform' => new Enum(Platform::class)
		];
	}

	/**
	 * @return DevicePersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new DevicePersistable());
	}
}