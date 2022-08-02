<?php
namespace RealEstate\DAL\Amc\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Assignee\Entities\CustomerFee;

class CustomerFeeByStateMetadata extends BaseFeeByStateMetadata
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_customer_state_fees');

        parent::define($builder);

        $builder
            ->createManyToOne('fee', CustomerFee::class)
            ->build();
    }
}
