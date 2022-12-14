<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Customer\Entities\AdditionalDocumentType;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('order_additional_documents');

		$this->defineId($builder);

		$builder
			->createManyToOne('type', AdditionalDocumentType::class)
			->build();

		$builder
			->createField('label', 'string')
			->nullable(true)
			->build();

		$builder
			->createManyToOne('document', Document::class)
			->build();

		$builder
			->createManyToOne('order', Order::class)
			->build();

		$builder
			->createField('createdAt', 'datetime')
			->build();
	}
}