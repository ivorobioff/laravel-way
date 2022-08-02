<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Objects\Conditions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ConditionsTransformer extends BaseTransformer
{
	/**
	 * @param Conditions $conditions
	 * @return array
	 */
	public function transform($conditions)
	{
		return $this->extract($conditions);
	}
}