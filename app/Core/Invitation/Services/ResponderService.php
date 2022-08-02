<?php
namespace RealEstate\Core\Invitation\Services;

use RealEstate\Core\Invitation\Criteria\SorterResolver;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ResponderService
{
	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolveSortable(Sortable $sortable)
	{
		return (new SorterResolver())->canResolve($sortable);
	}
}