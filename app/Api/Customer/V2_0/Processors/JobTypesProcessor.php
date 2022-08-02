<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Persistables\JobTypePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypesProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'title' => 'string',
			'local' => 'int',
			'isCommercial' => 'bool',
			'isPayable' => 'bool'
		];
	}

	/**
	 * @return JobTypePersistable $persistable
	 */
	public function createPersistable()
	{
		return $this->populate(new JobTypePersistable());
	}
}