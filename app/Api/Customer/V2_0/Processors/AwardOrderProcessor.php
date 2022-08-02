<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use DateTime;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AwardOrderProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'assignedAt' => 'datetime'
		];
	}

	/**
	 * @return DateTime|null
	 */
	public function getAssignedAt()
	{
		if ($assignedAt = $this->get('assignedAt')){
			return Shortcut::utc($assignedAt);
		}

		return null;
	}
}