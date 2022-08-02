<?php
namespace RealEstate\Api\Appraiser\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraiser\Entities\Ach;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchTransformer extends BaseTransformer
{
	/**
	 * @param Ach $item
	 * @return array
	 */
	public function transform($item)
	{
		return $this->extract($item);
	}
}