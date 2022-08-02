<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\AdditionalExternalDocument;
use RealEstate\Core\Appraisal\Entities\InstructionExternalDocument;
use RealEstate\DAL\Document\Types\FormatType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExternalDocumentMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('order_external_documents')
			->setSingleTableInheritance()
			->setDiscriminatorColumn('context', 'string', 20)
			->addDiscriminatorMapClass('instruction', InstructionExternalDocument::class)
			->addDiscriminatorMapClass('additional', AdditionalExternalDocument::class);

		$this->defineId($builder);

		$builder
			->createField('url', 'string')
			->build();

		$builder
			->createField('name', 'string')
			->length(100)
			->build();

		$builder
			->createField('size', 'integer')
			->build();

		$builder
			->createField('format', FormatType::class)
			->build();
	}
}