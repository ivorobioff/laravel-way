<?php
namespace RealEstate\DAL\Payment\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Payment\Types\StatusType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TransactionMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('transactions');

        $this->defineId($builder);

        $builder
            ->createManyToOne('owner', User::class)
            ->addJoinColumn('owner_id', 'id', true, false, 'CASCADE')
            ->build();

        $builder
            ->createField('status', StatusType::class)
            ->build();

        $builder
            ->createField('externalId', 'string')
            ->nullable(true)
            ->build();

        $builder
            ->createField('message', 'string')
            ->nullable(true)
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();
    }
}