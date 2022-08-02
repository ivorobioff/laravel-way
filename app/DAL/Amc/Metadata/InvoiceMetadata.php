<?php
namespace RealEstate\DAL\Amc\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Entities\Item;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('amc_invoices');

        $this->defineId($builder);

        $builder
            ->createField('from', 'datetime')
            ->columnName('`from`')
            ->build();

        $builder
            ->createField('to', 'datetime')
            ->columnName('`to`')
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();

        $builder
            ->createField('isPaid', 'boolean')
            ->build();

        $builder
            ->createManyToOne('amc', Amc::class)
            ->build();

        $builder
            ->createManyToOne('document', Document::class)
            ->build();

        $builder
            ->createField('amount', 'float')
            ->build();

        $builder
            ->createOneToMany('items', Item::class)
            ->mappedBy('invoice')
            ->build();
    }
}