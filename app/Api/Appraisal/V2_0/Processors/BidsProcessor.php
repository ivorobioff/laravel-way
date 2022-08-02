<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Persistables\BidPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidsProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'amount' => 'float',
			'estimatedCompletionDate' => 'datetime',
			'comments' => 'string'
		];
	}

	/**
	 * @return BidPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new BidPersistable());
	}
}