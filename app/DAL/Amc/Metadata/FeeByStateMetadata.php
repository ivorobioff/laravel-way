<?php
namespace RealEstate\DAL\Amc\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Fee;

class FeeByStateMetadata extends BaseFeeByStateMetadata
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_state_fees');

        parent::define($builder);

        $builder
            ->createManyToOne('fee', Fee::class)
            ->build();
    }
}
