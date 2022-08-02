<?php
namespace RealEstate\DAL\Document\Types;

use RealEstate\Core\Document\Enums\Format;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FormatType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Format::class;
	}
}