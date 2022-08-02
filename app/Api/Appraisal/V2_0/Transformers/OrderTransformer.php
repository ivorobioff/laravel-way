<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Order;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrderTransformer extends BaseTransformer
{
	/**
	 * @param Order $order
	 * @return array
	 */
	public function transform($order)
	{
		return $this->extract($order);
	}
}