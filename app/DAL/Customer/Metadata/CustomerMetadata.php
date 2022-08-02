<?php
namespace RealEstate\DAL\Customer\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Settings;
use RealEstate\DAL\Customer\Types\CompanyTypeType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->createField('name', 'string')
			->length(100)
			->build();

		$builder
			->createManyToMany('appraisers', Appraiser::class)
			->setJoinTable('customers_appraisers')
			->addJoinColumn('customer_id', 'id')
			->addInverseJoinColumn('appraiser_id', 'id')
			->build();

		$builder
			->createManyToMany('amcs', Amc::class)
			->setJoinTable('customers_amcs')
			->addJoinColumn('customer_id', 'id')
			->addInverseJoinColumn('amc_id', 'id')
			->build();

		$builder->createField('phone', 'string')
			->length(self::PHONE_LENGTH)
			->nullable(true)
			->build();

		$builder
			->createField('companyType', CompanyTypeType::class)
			->columnName('customer_company_type')
			->build();

		/*
		 * A workaround related to this issue https://github.com/doctrine/doctrine2/issues/4389#issuecomment-162367781
		 */
		$builder
			->createOneToMany('settings', Settings::class)
			->mappedBy('customer')
			->cascadeRemove()
			->build();

		$builder
			->createField('secret1', 'string')
			->length(static::SECRET_LENGTH)
			->build();

		$builder
			->createField('secret2', 'string')
			->length(static::SECRET_LENGTH)
			->build();
	}
}