<?php
namespace RealEstate\Core\Invitation\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\Core\Support\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FilterResolver extends AbstractResolver
{
	/**
	 * @param QueryBuilder $builder
	 * @param Status[] $statuses
	 */
	public function whereStatusIn(QueryBuilder $builder, array $statuses)
	{
		$statuses = array_map(function(Status $status){ return $status->value(); }, $statuses);

		$builder->andWhere($builder->expr()->in('i.status', ':statuses'))->setParameter('statuses', $statuses);
	}
}