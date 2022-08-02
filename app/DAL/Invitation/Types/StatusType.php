<?php
namespace RealEstate\DAL\Invitation\Types;

use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StatusType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Status::class;
	}
}