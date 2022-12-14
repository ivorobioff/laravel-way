<?php
namespace RealEstate\Core\Support\Criteria\Sorting;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\Join;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface ResolverInterface
{
	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolve(Sortable $sortable);

	/**
	 * @param QueryBuilder $builder
	 * @param Sortable $sortable
	 * @return null|Join
	 */
	public function resolve(QueryBuilder $builder, Sortable $sortable);
}