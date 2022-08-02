<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\Validation\Rules\MonthYearPair;
use RealEstate\Core\Payment\Objects\CreditCardRequisites;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCardProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'number' => 'string',
			'code' => 'string',
			'expiresAt' => new MonthYearPair(),
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'zip' => 'string'
		];
	}

	/**
	 * @return CreditCardRequisites
	 */
	public function createRequisites()
	{
		return $this->populate(new CreditCardRequisites());
	}
}