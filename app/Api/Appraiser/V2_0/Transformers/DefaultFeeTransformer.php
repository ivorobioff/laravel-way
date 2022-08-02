<?php
namespace RealEstate\Api\Appraiser\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraiser\Entities\DefaultFee;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DefaultFeeTransformer extends BaseTransformer
{
	/**
	 * @param DefaultFee $fee
	 * @return array
	 */
	public function transform($fee)
	{
		return $this->extract($fee);
	}
}