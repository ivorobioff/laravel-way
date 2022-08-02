<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Alias;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Entities\Coverage;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Location\Entities\State;
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
        $builder->setTable('amc_licenses');

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
            ->createManyToOne('amc', Amc::class)
            ->build();

        $builder
            ->createOneToMany('coverages', Coverage::class)
            ->mappedBy('license')
            ->build();

        $builder
            ->createManyToOne('document', Document::class)
            ->build();

        $builder
            ->createOneToOne('alias', Alias::class)
            ->cascadeRemove()
            ->build();
    }
}