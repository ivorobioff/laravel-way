<?php
namespace RealEstate\Push\Support;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StoryMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('request_logs');
        $this->defineId($builder);

        $builder
            ->createField('request', 'json_array')
            ->build();

        $builder
            ->createField('response', 'json_array')
            ->nullable(true)
            ->build();

        $builder
            ->createField('error', 'json_array')
            ->nullable(true)
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();
    }
}