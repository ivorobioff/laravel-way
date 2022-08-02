<?php
namespace RealEstate\Support\Chance;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AttemptMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('attempts');

        $this->defineId($builder);

        $builder
            ->createField('tag', 'string')
            ->build();

        $builder
            ->createField('data', 'json_array')
            ->build();

        $builder
            ->createField('quantity', 'integer')
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();

        $builder
            ->createField('attemptedAt', 'datetime')
            ->nullable(true)
            ->build();

    }
}