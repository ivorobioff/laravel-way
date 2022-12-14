<?php
namespace RealEstate\DAL\Customer\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Location\Entities\State;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('rules');

        $this->defineId($builder);

        $builder
            ->createField('available', 'json_array')
            ->build();

        $builder
            ->createField('requireEnv', 'boolean')
            ->nullable()
            ->build();


        foreach (['client', 'clientDisplayedOnReport'] as $item){
            $builder->createField($item.'Address1', 'string')
                ->nullable(true)
                ->build();

            $builder->createField($item.'Address2', 'string')
                ->nullable(true)
                ->build();

            $builder->createField($item.'Zip', 'string')
                ->nullable(true)
                ->build();

            $builder->createField($item.'City', 'string')
                ->nullable(true)
                ->build();

            $builder->createManyToOne($item.'State', State::class)
                ->addJoinColumn(snake_case($item.'State'), 'code')
                ->build();

        }

        $builder
            ->createField('displayFdic', 'boolean')
            ->nullable()
            ->build();
    }
}