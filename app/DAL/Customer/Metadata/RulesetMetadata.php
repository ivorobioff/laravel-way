<?php
namespace RealEstate\DAL\Customer\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\Rules;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesetMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('rulesets');

        $this->defineId($builder);

        $builder->createField('level', 'integer')->build();
        $builder->createField('label', 'string')->build();

        $builder
            ->createOneToOne('rules', Rules::class)
            ->cascadeRemove()
            ->build();

        $builder
            ->createManyToOne('customer', Customer::class)
            ->build();
    }
}