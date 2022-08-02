<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;

use RealEstate\Api\Appraiser\V2_0\Support\ConfigurationUtilities;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait AdditionalDocumentsConfigurationTrait
{
	/**
	 * @param array $options
	 * @return array
	 */
	protected function getAdditionalDocumentsConfiguration(array $options = [])
	{
		$namespace = ConfigurationUtilities::resolveNamespaceFromOptions($options);

		return [
			$namespace.'type' => 'int',
			$namespace.'label' => 'string',
			$namespace.'document' => 'document'
		];
	}
}