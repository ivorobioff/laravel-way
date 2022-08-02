<?php
namespace RealEstate\DAL\Customer\Types;

use RealEstate\Core\Customer\Enums\ExtraFormat;
use RealEstate\Core\Customer\Enums\ExtraFormats;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExtraFormatsType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ExtraFormat::class;
	}

	protected function getEnumCollectionClass()
	{
		return ExtraFormats::class;
	}
}