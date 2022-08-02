<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$this->defineId($builder);

		$builder->setTable('bids');

		$builder
			->createField('amount', 'float')
			->build();

		$builder
			->createField('estimatedCompletionDate', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createOneToOne('order', Order::class)
			->build();

		$builder
			->createField('comments', 'string')
			->nullable(true)
			->build();
	}
}