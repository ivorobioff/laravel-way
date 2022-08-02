<?php
namespace RealEstate\DAL\Location\Support;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PlaceMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('places');
        $this->defineId($builder);

        $builder
            ->createField('address', 'string')
            ->build();

        $builder
            ->createField('latitude', 'string')
            ->nullable(true)
            ->length(self::LATITUDE_LENGTH)
            ->build();

        $builder
            ->createField('longitude', 'string')
            ->nullable(true)
            ->length(self::LONGITUDE_LENGTH)
            ->build();

        $builder
            ->createField('error', ErrorType::class)
            ->nullable(true)
            ->build();

        $builder
            ->createField('message', 'text')
            ->nullable(true)
            ->build();

        $builder
            ->createField('attempts', 'integer')
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();

        $builder
            ->createField('updatedAt', 'datetime')
            ->build();
    }
}