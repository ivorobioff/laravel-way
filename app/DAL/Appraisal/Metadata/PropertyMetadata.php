<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Contact;
use RealEstate\Core\Location\Entities\County;
use RealEstate\Core\Location\Entities\State;
use RealEstate\DAL\Appraisal\Types\BestPersonToContactType;
use RealEstate\DAL\Appraisal\Types\OccupancyType;
use RealEstate\DAL\Appraisal\Types\OwnerInterestsType;
use RealEstate\DAL\Appraisal\Types\ValueQualifiersType;
use RealEstate\DAL\Appraisal\Types\ValueTypesType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PropertyMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('properties');

		$this->defineId($builder);
		
		$builder
			->createField('type', 'string')
            ->nullable(true)
			->build();

		$builder
			->createField('viewType', 'string')
			->nullable(true)
			->build();

        $builder
            ->createField('characteristics', 'json_array')
            ->build();

		$builder
			->createField('approxBuildingSize', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('approxLandSize', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('buildingAge', 'integer')
			->nullable(true)
			->build();

		$builder
			->createField('numberOfStories', 'integer')
			->nullable(true)
			->build();

		$builder
			->createField('numberOfUnits', 'integer')
			->nullable(true)
			->build();

		$builder
			->createField('grossRentalIncome', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('incomeSalesCost', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('valueTypes', ValueTypesType::class)
			->build();

		$builder
			->createField('valueQualifiers', ValueQualifiersType::class)
			->build();

		$builder
			->createField('ownerInterests', OwnerInterestsType::class)
			->build();
		
		$builder->createField('address1', 'string')
			->length(self::ADDRESS_LENGTH)
			->build();

		$builder->createField('address2', 'string')
			->length(self::ADDRESS_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('zip', 'string')
			->length(self::ZIP_LENGTH)
			->build();

		$builder->createField('city', 'string')
			->length(self::CITY_LENGTH)
			->build();

		$builder->createField('latitude', 'string')
			->length(self::LATITUDE_LENGTH)
			->nullable(true)
			->build();

		$builder->createField('longitude', 'string')
			->length(self::LONGITUDE_LENGTH)
			->nullable(true)
			->build();

		$builder->createManyToOne('state', State::class)
			->addJoinColumn('state', 'code')
			->build();

		$builder
			->createManyToOne('county', County::class)
			->build();

		$builder
			->createField('occupancy', OccupancyType::class)
			->build();

		$builder
			->createField('bestPersonToContact', BestPersonToContactType::class)
			->build();

		$builder
			->createOneToMany('contacts', Contact::class)
			->cascadeRemove()
			->mappedBy('property')
			->build();

		$builder
			->createField('legal', 'string')
			->nullable(true)
			->build();

		$builder
			->createField('additionalComments', 'text')
			->nullable(true)
			->build();
	}
}