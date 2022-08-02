<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Location\Entities\County;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class BaseFeeByCountyMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $this->defineId($builder);

        $builder
            ->createManyToOne('county', County::class)
            ->build();

        $builder
            ->createField('amount', 'float')
            ->build();
    }
}