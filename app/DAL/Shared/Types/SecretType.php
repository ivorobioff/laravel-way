<?php
namespace RealEstate\DAL\Shared\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use RealEstate\DAL\Support\AbstractType;
use Crypt;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SecretType extends AbstractType
{
	/**
	 * @param array $fieldDeclaration
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return 'VARCHAR(255)';
	}

	/**
	 * @param string $value
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value === null){
			return null;
		}

		return Crypt::encrypt($value);
	}

	/**
	 * @param string $value
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		if ($value === null){
			return null;
		}

		return Crypt::decrypt($value);
	}
}