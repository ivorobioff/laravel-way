<?php
namespace RealEstate\Api\Support\Searchable;

use RealEstate\Core\Support\Criteria\Sorting\Direction;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;
use RuntimeException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait SortableTrait
{
	/**
	 * @return Sortable[]
	 */
	public function createSortables()
	{
		$query = $this->get('orderBy');

		if (!$query){
			return [];
		}

		$fields = explode(',', $query);

		$sortables = [];

		foreach ($fields as $field) {

			$matches = [];
			if (!preg_match('/([^:]*)(?::(asc|desc))?/i', $field, $matches)) {
				throw new RuntimeException('Unable to sort the result due to invalid sequence of the provided fields.');
			}

			$field = $matches[1];

			$direction = strtolower(array_take($matches, 2, 'asc'));

			$direction = new Direction($direction);

			$sortable = new Sortable($field, $direction);

			if ($this->isResolvable($sortable)){
				$sortables[] = $sortable;
			}
		}

		return $sortables;
	}

	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	protected abstract function isResolvable(Sortable $sortable);
}