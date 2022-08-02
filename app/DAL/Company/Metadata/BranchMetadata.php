<?php
namespace RealEstate\DAL\Company\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraiser\Entities\Eo;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Location\Entities\State;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

class BranchMetadata extends AbstractMetadataProvider
{
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('branches');

        $this->defineId($builder);

        $builder
            ->createField('name', 'string')
            ->build();

        $builder
            ->createField('isDefault', 'boolean')
            ->build();

        // Not unique because the same tax ID can be used on many branches within the same company
        $builder
            ->createField('taxId', 'string')
            ->columnName('tin')
            ->length(11)
            ->nullable(true)
            ->build();

        $builder
            ->createField('address1', 'string')
            ->length(self::ADDRESS_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createField('address2', 'string')
            ->length(self::ADDRESS_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createField('city', 'string')
            ->length(self::CITY_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createManyToOne('state', State::class)
            ->addJoinColumn('state', 'code')
            ->build();

        $builder
            ->createField('zip', 'string')
            ->length(self::ZIP_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createField('assignmentZip', 'string')
            ->length(self::ZIP_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createOneToOne('eo', Eo::class)
            ->cascadeRemove()
            ->build();

        $builder
            ->createOneToMany('staff', Staff::class)
            ->mappedBy('branch')
            ->cascadeRemove()
            ->build();

        $builder
            ->createManyToOne('company', Company::class)
            ->build();
    }
}
