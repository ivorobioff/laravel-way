<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Objects\Counter;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountersTransformer extends BaseTransformer
{
	/**
	 * @param Counter[] $counters
	 * @return array
	 */
	public function transform($counters)
	{
		$data = [];

		foreach ($counters as $counter){
			$data[camel_case((string) $counter->getQueue())] = $counter->getTotal();
		}

		return $data;
	}
}