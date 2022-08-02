<?php
namespace RealEstate\Core\Appraisal\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\Sorting\AbstractResolver;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageSorterResolver extends AbstractResolver
{
	/**
	 * @param QueryBuilder $builder
	 * @param string $direction
	 */
	public function byCreatedAt(QueryBuilder $builder, $direction)
	{
		$builder->addOrderBy('m.createdAt', $direction);
	}
}