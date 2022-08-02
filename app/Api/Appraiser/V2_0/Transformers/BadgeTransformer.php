<?php
namespace RealEstate\Api\Appraiser\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Objects\Badge;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BadgeTransformer extends BaseTransformer
{
	/**
	 * @param Badge $badge
	 * @return array
	 */
	public function transform($badge)
	{
		return $this->extract($badge);
	}
}