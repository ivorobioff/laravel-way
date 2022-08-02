<?php
namespace RealEstate\DAL\Appraiser\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraiser\Entities\License;
use RealEstate\Core\Location\Entities\County;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CoverageMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('coverages');

		$this->defineId($builder);

		$builder->createField('zip', 'string')
			->length(self::ZIP_LENGTH)
			->nullable(true)
			->build();

		$builder
			->createManyToOne('county', County::class)
			->build();

		$builder
			->createManyToOne('license', License::class)
			->inversedBy('coverages')
			->build();
	}
}