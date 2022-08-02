<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\Customer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerTransformer extends BaseTransformer
{
	/**
	 * @param Customer $customer
	 * @return array
	 */
	public function transform($customer)
	{
		return $this->extract($customer);
	}
}