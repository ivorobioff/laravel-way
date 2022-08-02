<?php
namespace RealEstate\DAL\Back\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Back\Types\ValueType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('back_settings');

		$builder
			->createField('name', 'string')
			->makePrimaryKey()
			->build();

		$builder
			->createField('value', ValueType::class)
			->build();
	}
}