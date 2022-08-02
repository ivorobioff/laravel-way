<?php
namespace RealEstate\DAL\Appraiser\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Entities\Coverage;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Location\Entities\State;
use RealEstate\DAL\Asc\Types\CertificationsType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('licenses');

		$this->defineId($builder);

		$builder
			->createField('number', 'string')
			->length(self::LICENSE_NUMBER_LENGTH)
			->build();

		$builder
			->createManyToOne('state', State::class)
			->addJoinColumn('state', 'code')
			->build();

		$builder
			->createField('expiresAt', 'datetime')
			->build();

		$builder
			->createField('certifications', CertificationsType::class)
			->build();

        $builder
			->createManyToOne('appraiser', Appraiser::class)
			->inversedBy('licenses')
			->build();

        $builder
			->createField('isPrimary', 'boolean')
			->build();

		$builder
			->createField('isFhaApproved', 'boolean')
			->columnName('is_fha')
			->build();

		$builder->createField('isCommercial', 'boolean')
			->columnName('is_commercial')
			->build();

		$builder
			->createOneToMany('coverages', Coverage::class)
			->mappedBy('license')
			->build();

		$builder
			->createManyToOne('document', Document::class)
			->build();
    }
}