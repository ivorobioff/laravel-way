<?php
namespace RealEstate\Api\User\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\User\Entities\Device;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeviceTransformer extends BaseTransformer
{
	/**
	 * @param Device $device
	 * @return array
	 */
	public function transform($device)
	{
		return $this->extract($device);
	}
}