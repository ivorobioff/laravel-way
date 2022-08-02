<?php
namespace RealEstate\DAL\Location\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Entities\Zip;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountyMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('counties');

		$this->defineId($builder);

		$builder->createManyToOne('state', State::class)
			->addJoinColumn('state', 'code')
			->build();
		
		$builder
			->createField('title', 'string')
			->build();

		$builder
			->createOneToMany('zips', Zip::class)
			->mappedBy('county')
			->build();
	}
}