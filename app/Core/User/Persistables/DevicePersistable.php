<?php
namespace RealEstate\Core\User\Persistables;

use RealEstate\Core\User\Properties\Device\PlatformPropertyTrait;
use RealEstate\Core\User\Properties\Device\TokenPropertyTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DevicePersistable
{
	use TokenPropertyTrait;
	use PlatformPropertyTrait;
}