<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Reconsideration;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationTransformer extends BaseTransformer
{
	/**
	 * @param Reconsideration $reconsideration
	 * @return array
	 */
	public function transform($reconsideration)
	{
		return $this->extract($reconsideration);
	}
}