<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\EnumCollection;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Workflow extends EnumCollection
{
	/**
	 * @return string
	 */
	public function getEnumClass()
	{
		return ProcessStatus::class;
	}
}