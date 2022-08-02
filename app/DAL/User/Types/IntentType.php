<?php
namespace RealEstate\DAL\User\Types;

use RealEstate\Core\User\Enums\Intent;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IntentType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Intent::class;
	}
}