<?php
namespace RealEstate\Api\Location\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Location\Entities\County;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountyTransformer extends BaseTransformer
{
	/**
	 * @param County $county
	 * @return array
	 */
	public function transform($county)
	{
		return $this->extract($county);
	}
}