<?php
namespace RealEstate\Api\Support\Searchable;

use Restate\Libraries\Validation\Rules\Moment;
use DateTime;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DateTimeResolver
{
	/**
	 * @param string $datetime
	 * @return bool
	 */
	public function isProcessable($datetime)
	{
		return !(new Moment())->check($datetime);
	}

	/**
	 * @param string $datetime
	 * @return DateTime
	 */
	public function resolve($datetime)
	{
		return Shortcut::utc($datetime);
	}
}