<?php
namespace RealEstate\Core\User\Properties\Device;

use RealEstate\Core\User\Enums\Platform;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait PlatformPropertyTrait
{
	/**
	 * @var Platform
	 */
	private $platform;

	/**
	 * @param Platform $platform
	 */
	public function setPlatform(Platform $platform)
	{
		$this->platform = $platform;
	}

	public function getPlatform()
	{
		return $this->platform;
	}
}