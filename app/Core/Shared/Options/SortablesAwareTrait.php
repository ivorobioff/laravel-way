<?php
namespace RealEstate\Core\Shared\Options;

use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait SortablesAwareTrait
{
	/**
	 * @var Sortable[]
	 */
	private $sortables = [];

	/**
	 * @param Sortable[] $sortables
	 */
	public function setSortables(array $sortables)
	{
		$this->sortables = $sortables;
	}

	/**
	 * @return Sortable[]
	 */
	public function getSortables()
	{
		return $this->sortables;
	}
}