<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_fees');

        $this->defineId($builder);

        $builder
            ->createField('isEnabled', 'boolean')
            ->build();

        $builder
            ->createField('amount', 'float')
            ->build();

        $builder
            ->createManyToOne('jobType', JobType::class)
            ->build();

        $builder
            ->createManyToOne('amc', Amc::class)
            ->build();
    }
}