<?php
namespace RealEstate\Letter\Support;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FrequencyMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('emails_frequency_tracker');

        $this->defineId($builder);

        $builder
            ->createManyToOne('order', Order::class)
            ->addJoinColumn('order_id', 'id', true, false, 'CASCADE')
            ->build();


        $builder
            ->createField('alias', 'string')
            ->build();

        $builder
            ->createField('updatedAt', 'datetime')
            ->build();

    }
}