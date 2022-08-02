<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Appraisal\Types\RequestType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptedConditionsMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('accepted_conditions');

		$this->defineId($builder);

		$builder
			->createField('request', RequestType::class)
			->build();

		$builder
			->createField('dueDate', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('fee', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('explanation', 'text')
			->nullable(true)
			->build();

		$builder
			->createField('additionalComments', 'string')
			->nullable(true)
			->build();
	}
}