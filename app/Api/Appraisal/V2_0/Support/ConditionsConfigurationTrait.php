<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;

use RealEstate\Api\Appraiser\V2_0\Support\ConfigurationUtilities;
use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Core\Appraisal\Enums\Request;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait ConditionsConfigurationTrait
{
	/**
	 * @param array $options
	 * @return array
	 */
	protected function getConditionsConfiguration(array $options = [])
	{
		$namespace = ConfigurationUtilities::resolveNamespaceFromOptions($options);

		return [
			$namespace . 'request' => new Enum(Request::class),
			$namespace . 'fee' => 'float',
			$namespace . 'dueDate' => 'datetime',
			$namespace . 'explanation' => 'string'
		];
	}
}