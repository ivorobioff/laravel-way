<?php
namespace RealEstate\DAL\Appraisal\Types;

use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ProcessStatusType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return ProcessStatus::class;
	}
}