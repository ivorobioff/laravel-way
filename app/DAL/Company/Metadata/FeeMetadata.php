<?php
namespace RealEstate\DAL\Company\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeeMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('company_fees');

        $this->defineId($builder);

        $builder
            ->createField('amount', 'float')
            ->build();

        $builder
            ->createManyToOne('jobType', JobType::class)
            ->addJoinColumn('job_type_id', 'id', true, false, 'CASCADE')
            ->build();

        $builder
            ->createManyToOne('company', Company::class)
            ->addJoinColumn('company_id', 'id', true, false, 'CASCADE')
            ->build();
    }
}