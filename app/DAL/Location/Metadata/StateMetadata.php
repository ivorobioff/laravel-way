<?php
namespace RealEstate\DAL\Location\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\MetadataProviderInterface;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StateMetadata implements MetadataProviderInterface
{

    /**
     *
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('states');

        $builder->createField('code', 'string')
            ->makePrimaryKey()
            ->length(3)
            ->build();

        $builder->createField('name', 'string')
            ->length(50)
            ->build();
    }
}