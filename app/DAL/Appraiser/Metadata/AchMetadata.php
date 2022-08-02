<?php
namespace RealEstate\DAL\Appraiser\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Shared\Types\SecretType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('ach');

		$this->defineId($builder);

		$builder
			->createField('bankName', 'string')
			->build();

		$builder
			->createField('accountNumber', SecretType::class)
			->length(20)
			->build();

		$builder
			->createField('accountType', 'string')
			->build();

		$builder
			->createField('routing', SecretType::class)
			->length(9)
			->build();
	}
}