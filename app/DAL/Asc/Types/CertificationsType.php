<?php
namespace RealEstate\DAL\Asc\Types;

use RealEstate\Core\Asc\Enums\Certification;
use RealEstate\Core\Asc\Enums\Certifications;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CertificationsType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return Certification::class;
    }

	/**
	 * @return string
	 */
	protected function getEnumCollectionClass()
	{
		return Certifications::class;
	}
}