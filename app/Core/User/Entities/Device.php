<?php
namespace RealEstate\Core\User\Entities;

use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\User\Properties\Device\PlatformPropertyTrait;
use RealEstate\Core\User\Properties\Device\TokenPropertyTrait;
use RealEstate\Core\User\Properties\UserPropertyTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Device
{
	use IdPropertyTrait;
	use UserPropertyTrait;
	use TokenPropertyTrait;
	use PlatformPropertyTrait;
}