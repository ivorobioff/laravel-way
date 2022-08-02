<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Objects\Totals;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class TotalsTransformer extends BaseTransformer
{
	/**
	 * @param Totals[] $totals
	 * @return array
	 */
	public function transform($totals)
	{
		return [
			'paid' => $this->extract($totals['paid']),
			'unpaid' => $this->extract($totals['unpaid'])
		];
	}
}