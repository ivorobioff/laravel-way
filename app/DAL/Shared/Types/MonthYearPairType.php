<?php
namespace RealEstate\DAL\Shared\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use RealEstate\Core\Shared\Objects\MonthYearPair;
use RealEstate\DAL\Support\AbstractType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MonthYearPairType extends AbstractType
{
	/**
	 * @param array $fieldDeclaration
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return 'VARCHAR(50)';
	}

	/**
	 * @param MonthYearPair $value
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value === null){
			return null;
		}

		return json_encode(['month' => $value->getMonth(), 'year' => $value->getYear()]);
	}

	/**
	 * @param mixed $value
	 * @param AbstractPlatform $platform
	 * @return MonthYearPair
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		if ($value === null){
			return null;
		}

		$pair = new MonthYearPair();

		$data = json_decode($value, true);

		$pair->setMonth($data['month']);
		$pair->setYear($data['year']);

		return $pair;
	}
}