<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Property;
use RealEstate\DAL\Appraisal\Types\ContactTypeType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ContactMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('contacts');

		$this->defineId($builder);

		$builder->createField('firstName', 'string')
			->length(self::FIRST_NAME_LENGTH)
			->nullable(true)
			->build();
		
		$builder->createField('lastName', 'string')
			->length(self::LAST_NAME_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('displayName', 'string')
			->nullable(true)
			->build();

		$builder->createField('middleName', 'string')
			->length(self::MIDDLE_NAME_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('homePhone', 'string')
			->length(self::PHONE_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('workPhone', 'string')
			->length(self::PHONE_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('cellPhone', 'string')
			->length(self::PHONE_LENGTH)
			->nullable(true)
			->build();

		$builder
			->createField('type', ContactTypeType::class)
			->build();

		$builder
			->createManyToOne('property', Property::class)
			->inversedBy('contacts')
			->build();

		$builder
			->createField('name', 'string')
			->nullable(true)
			->build();

		$builder
			->createField('email', 'string')
			->nullable(true)
			->build();

        $builder
            ->createField('intentProceedDate', 'datetime')
            ->nullable(true)
            ->build();
	}
}