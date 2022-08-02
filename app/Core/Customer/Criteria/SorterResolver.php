<?php
namespace RealEstate\Core\Customer\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\Sorting\AbstractResolver;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SorterResolver extends AbstractResolver
{
	/**
	 * @param QueryBuilder $builder
	 * @param string $direction
	 */
	public function byName(QueryBuilder $builder, $direction)
	{
		$builder->addOrderBy('c.name', $direction);
	}
}