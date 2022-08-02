<?php
namespace RealEstate\DAL\Customer\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('customer_job_types');

		$this->defineId($builder);

		$builder
			->createField('title', 'string')
			->build();

		$builder
			->createField('isCommercial', 'boolean')
			->build();

		$builder
			->createField('isPayable', 'boolean')
			->build();

		$builder
			->createManyToOne('local', JobType::class)
			->addJoinColumn('local', 'id')
			->build();

		$builder
			->createField('isHidden', 'boolean')
			->build();

		$builder
			->createManyToOne('customer', Customer::class)
			->build();
	}
}