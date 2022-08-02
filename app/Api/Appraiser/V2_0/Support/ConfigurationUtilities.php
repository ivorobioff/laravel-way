<?php
namespace RealEstate\Api\Appraiser\V2_0\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ConfigurationUtilities
{
	/**
	 * @param array $options
	 * @return mixed|string
	 */
	public static function resolveNamespaceFromOptions(array $options)
	{
		$namespace = array_take($options, 'namespace', '');

		if ($namespace) {
			$namespace = $namespace . '.';
		}

		return $namespace;
	}
}