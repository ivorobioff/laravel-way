<?php
namespace RealEstate\DAL\Customer\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\DAL\Customer\Types\ExtraFormatsType;
use RealEstate\DAL\Customer\Types\FormatsType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormatsMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$this->defineId($builder);

		$builder->setTable('document_supported_formats');

		$builder
			->createManyToOne('jobType', JobType::class)
			->build();

		$builder
			->createField('primary', FormatsType::class)
			->columnName('`primary`')
			->build();

		$builder
			->createField('extra', ExtraFormatsType::class)
			->nullable(true)
			->build();

		$builder
			->createManyToOne('customer', Customer::class)
			->build();
	}
}