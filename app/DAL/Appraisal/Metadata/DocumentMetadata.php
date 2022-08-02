<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Document\Entities\Document as Source;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('order_documents');

		$this->defineId($builder);

		$builder
			->createField('createdAt', 'datetime')
			->build();

		$builder
			->createField('showToAppraiser', 'boolean')
			->nullable(true)
			->build();

		$builder
			->createManyToMany('primaries', Source::class)
			->setJoinTable('order_documents_primaries')
			->addInverseJoinColumn('primary_document_id', 'id')
			->build();

		$builder
			->createManyToMany('extra', Source::class)
			->setJoinTable('order_documents_extra')
			->addInverseJoinColumn('extra_document_id', 'id')
			->build();

		$builder
			->createManyToOne('order', Order::class)
			->build();
	}
}