<?php
namespace RealEstate\Api\Support\Searchable;

use Restate\Libraries\Validation\Rules\IntegerCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IntResolver
{
	/**
	 * @param string $value
	 * @return int
	 */
	public function isProcessable($value)
	{
		return !(new IntegerCast(true))->check($value);
	}

	/**
	 * @param string $value
	 * @return int
	 */
	public function resolve($value)
	{
		return (int) $value;
	}
}