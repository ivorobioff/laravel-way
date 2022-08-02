<?php
namespace RealEstate\Api\Appraiser\V2_0\Transformers;

use RealEstate\Api\Appraiser\V2_0\Support\LicenseConfigurationTrait;
use RealEstate\Api\Assignee\V2_0\Support\CoverageReformatter;
use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraiser\Entities\Appraiser;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserTransformer extends BaseTransformer
{
	use LicenseConfigurationTrait;

	/**
     * @param object|Appraiser $item
     * @return array
     */
    public function transform($item)
    {
        $data = $this->extract($item, $this->getExtractorConfig([
			'namespace' => 'qualifications.primaryLicense'
		]));

		$path = 'qualifications.primaryLicense.coverage';

		if (array_has($data, $path)){
			array_set($data, $path, CoverageReformatter::reformat(array_get($data, $path)));
		}

		return $data;
    }
}