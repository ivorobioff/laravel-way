<?php
namespace RealEstate\Core\Amc\Criteria;
use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceFilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param bool $flag
     */
    public function whereIsPaidEqual(QueryBuilder $builder, $flag)
    {
        $builder
            ->andWhere($builder->expr()->eq('i.isPaid', ':isPaid'))
            ->setParameter('isPaid', $flag);
    }
}