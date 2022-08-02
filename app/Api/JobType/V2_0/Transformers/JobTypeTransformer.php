<?php
namespace RealEstate\Api\JobType\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\JobType\Entities\JobType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeTransformer extends BaseTransformer
{
	/**
	 * @param JobType $jobType
	 * @return array
	 */
	public function transform($jobType)
	{
		return $this->extract($jobType);
	}
}