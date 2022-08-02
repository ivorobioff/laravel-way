<?php
namespace RealEstate\Api\Appraiser\V2_0\Transformers;

use RealEstate\Api\Appraiser\V2_0\Support\LicenseConfigurationTrait;
use RealEstate\Api\Assignee\V2_0\Support\CoverageReformatter;
use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraiser\Entities\License;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseTransformer extends BaseTransformer
{
	use LicenseConfigurationTrait;

    /**
     * @param License $license
     * @return array
     */
    public function transform($license)
    {
        $data = $this->extract($license, $this->getExtractorConfig());

		$data['coverage'] = CoverageReformatter::reformat($data['coverage']);

		return $data;
    }
}