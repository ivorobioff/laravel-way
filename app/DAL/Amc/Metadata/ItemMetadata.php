<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Invoice;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ItemMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_invoice_items');
        $this->defineId($builder);

        $builder
            ->createField('fileNumber', 'string')
            ->length(static::FILE_NUMBER_LENGTH)
            ->build();

        $builder
            ->createField('loanNumber', 'string')
            ->length(static::LOAN_NUMBER_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createField('borrowerName', 'string')
            ->nullable(true)
            ->build();

        $builder
            ->createField('jobType', 'string')
            ->build();

        $builder
            ->createField('address', 'string')
            ->build();

        $builder
            ->createField('orderedAt', 'datetime')
            ->build();

        $builder
            ->createField('completedAt', 'datetime')
            ->build();

        $builder
            ->createField('amount', 'float')
            ->build();

        $builder
            ->createManyToOne('order', Order::class)
            ->addJoinColumn('order_id', 'id', true, false, 'SET NULL')
            ->build();

        $builder
            ->createManyToOne('invoice', Invoice::class)
            ->build();
    }
}