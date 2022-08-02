<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Persistables\RevisionPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RevisionsProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'checklist' => 'string[]',
			'message' => 'string'
		];
	}

	/**
	 * @return RevisionPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new RevisionPersistable());
	}
}