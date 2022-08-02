<?php
namespace RealEstate\Core\Customer\Criteria;
use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeFilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param bool $flag
     */
    public function whereIsPayableEqual(QueryBuilder $builder, $flag)
    {
        $builder->andWhere($builder->expr()->eq('j.isPayable', ':isPayable'))->setParameter('isPayable', $flag);
    }
}