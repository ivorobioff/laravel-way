<?php
namespace RealEstate\Support;

use Illuminate\Foundation\Bootstrap\LoadConfiguration;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait RegisterLogglyViaBootstrapperTrait
{
	/**
	 * @param array $bootstrappers
	 * @return array
	 */
	public function registerLogglyViaBootstrapper(array $bootstrappers)
	{
		$key = array_search(LoadConfiguration::class, $bootstrappers);

		array_splice($bootstrappers, $key + 1, 0, LogglyRegistrar::class);

		return $bootstrappers;
	}
}