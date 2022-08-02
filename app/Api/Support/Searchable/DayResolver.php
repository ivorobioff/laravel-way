<?php
namespace RealEstate\Api\Support\Searchable;

use Restate\Libraries\Validation\Rules\Moment;
use RealEstate\Core\Support\Criteria\Day;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DayResolver
{
	/**
	 * @param string $date
	 * @return bool
	 */
	public function isProcessable($date)
	{
		return !(new Moment('Y-m-d'))->check($date);
	}

	/**
	 * @param string $date
	 * @return Day
	 */
	public function resolve($date)
	{
		return new Day($date);
	}
}