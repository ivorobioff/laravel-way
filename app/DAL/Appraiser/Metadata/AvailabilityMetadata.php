<?php
namespace RealEstate\DAL\Appraiser\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AvailabilityMetadata extends AbstractMetadataProvider
{
	/**
	 *
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('availabilities');
		$this->defineId($builder);

		$builder
			->createField('isOnVacation', 'boolean')
			->build();

		$builder
			->createField('from', 'datetime')
			->columnName('`from`')
			->nullable(true)
			->build();

		$builder
			->createField('to', 'datetime')
			->columnName('`to`')
			->nullable(true)
			->build();

		$builder
			->createField('message', 'text')
			->nullable(true)
			->build();
	}
}