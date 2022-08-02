<?php
namespace RealEstate\DAL\Location\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Location\Entities\County;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ZipMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('zips');

		$this->defineId($builder);

		$builder->createField('code', 'string')
			->length(self::ZIP_LENGTH)
			->build();

		$builder
			->createManyToOne('county', County::class)
			->inversedBy('zips')
			->build();
	}
}