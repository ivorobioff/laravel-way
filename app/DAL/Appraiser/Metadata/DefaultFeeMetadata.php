<?php
namespace RealEstate\DAL\Appraiser\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DefaultFeeMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('default_fees');

		$this->defineId($builder);

		$builder
			->createField('amount', 'float')
			->build();

		$builder
			->createManyToOne('jobType', JobType::class)
			->build();

		$builder
			->createManyToOne('appraiser', Appraiser::class)
			->inversedBy('defaultFees')
			->build();
	}
}