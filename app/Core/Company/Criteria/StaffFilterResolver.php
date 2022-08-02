<?php
namespace RealEstate\Core\Company\Criteria;
use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;
use RealEstate\Core\Support\Criteria\Join;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffFilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param string $class
     * @return Join[]
     */
    public function whereUserClassEqual(QueryBuilder $builder, $class)
    {
        $builder->andWhere($builder->expr()->isInstanceOf('u', $class));
        return [new Join('s.user', 'u')];
    }
}