<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Enums\CompanyType;
use RealEstate\Core\Customer\Persistables\CustomerPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomersProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	public function configuration()
	{
		$config =  [
			'username' => 'string',
			'name' => 'string',
			'phone' => 'string',
			'companyType' => new Enum(CompanyType::class),
		];

		if (!$this->isPatch()){
			$config['password'] = 'string';
		}

		return $config;
	}

	/**
	 * @return CustomerPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new CustomerPersistable());
	}
}