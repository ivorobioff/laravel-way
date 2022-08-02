<?php
namespace RealEstate\DAL\Appraisal\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SupportingDetailsMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('order_supporting_details');

        $this->defineId($builder);

        $builder->createOneToOne('order', Order::class)
            ->addJoinColumn('order_id', 'id', true, false, 'CASCADE')
            ->inversedBy('supportingDetails')
            ->build();

        $builder
            ->createField('unacceptedRemindedAt', 'datetime')
            ->nullable(true)
            ->build();
    }
}