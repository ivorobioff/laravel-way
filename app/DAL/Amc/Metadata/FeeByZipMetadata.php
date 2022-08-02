<?php
namespace RealEstate\DAL\Amc\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Fee;

class FeeByZipMetadata extends BaseFeeByZipMetadata
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_zip_fees');

        parent::define($builder);

        $builder
            ->createManyToOne('fee', Fee::class)
            ->build();
    }
}
