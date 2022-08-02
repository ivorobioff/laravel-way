<?php
namespace RealEstate\DAL\Appraisal\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use RealEstate\Core\Appraisal\Enums\Workflow;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class WorkflowType extends ProcessStatusType
{
	/**
	 * @return string
	 */
	protected function getEnumCollectionClass()
	{
		return Workflow::class;
	}

	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return 'TEXT';
	}

}