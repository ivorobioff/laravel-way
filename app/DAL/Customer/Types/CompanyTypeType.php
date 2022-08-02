<?php
namespace RealEstate\DAL\Customer\Types;

use RealEstate\Core\Customer\Enums\CompanyType;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Tushar Ambalia <tusharambalia17@gmail.com>
 */
class CompanyTypeType extends EnumType
{
	/**
	 * @return string
	 */
	protected function getEnumClass()
	{
		return CompanyType::class;
	}
}