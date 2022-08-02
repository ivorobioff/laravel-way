<?php
namespace RealEstate\DAL\Log\Types;

use RealEstate\Core\Log\Enums\Action;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ActionType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Action::class;
	}
}