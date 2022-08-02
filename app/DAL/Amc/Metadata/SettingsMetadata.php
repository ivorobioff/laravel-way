<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_settings');

        $this->defineId($builder);

        $builder->createOneToOne('amc', Amc::class)
            ->build();

        $builder
            ->createField('pushUrl', 'string')
            ->nullable(true)
            ->build();
    }
}