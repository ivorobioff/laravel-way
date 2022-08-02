<?php
namespace RealEstate\DAL\Customer\Types;

use RealEstate\Core\Customer\Enums\Format;
use RealEstate\Core\Customer\Enums\Formats;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FormatsType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Format::class;
	}

	protected function getEnumCollectionClass()
	{
		return Formats::class;
	}
}