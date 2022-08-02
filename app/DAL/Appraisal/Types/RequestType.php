<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\Request;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RequestType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return Request::class;
	}
}