<?php
namespace RealEstate\Core\Customer\Services;

use RealEstate\Core\Customer\Criteria\SorterResolver;
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