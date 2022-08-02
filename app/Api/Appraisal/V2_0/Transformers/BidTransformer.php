<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Bid;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidTransformer extends BaseTransformer
{
	/**
	 * @param Bid $bid
	 * @return array
	 */
	public function transform($bid)
	{
		return $this->extract($bid);
	}
}