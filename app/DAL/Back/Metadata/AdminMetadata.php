<?php
namespace RealEstate\DAL\Back\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->createField('firstName', 'string')
            ->length(static::FIRST_NAME_LENGTH)
            ->build();

        $builder->createField('lastName', 'string')
            ->length(static::LAST_NAME_LENGTH)
            ->build();
    }
}