<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\DAL\Appraisal\Types\ComparablesType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('reconsiderations');

		$this->defineId($builder);

		$builder
			->createField('createdAt', 'datetime')
			->build();

		$builder
			->createField('comment', 'text')
			->build();

        $builder
            ->createManyToOne('document', AdditionalDocument::class)
            ->build();

		$builder
			->createField('comparables', ComparablesType::class)
			->build();

		$builder
			->createManyToOne('order', Order::class)
			->build();
	}
}