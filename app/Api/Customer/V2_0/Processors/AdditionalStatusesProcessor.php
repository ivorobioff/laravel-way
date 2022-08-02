<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Persistables\AdditionalStatusPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusesProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'title' => 'string',
			'comment' => 'string'
		];
	}

	/**
	 * @return AdditionalStatusPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new AdditionalStatusPersistable());
	}
}