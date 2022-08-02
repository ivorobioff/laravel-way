<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use RealEstate\Api\Appraisal\V2_0\Support\ConditionsConfigurationTrait;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Objects\Conditions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ConditionsProcessor extends BaseProcessor
{
	use ConditionsConfigurationTrait;

	protected function configuration()
	{
		return $this->getConditionsConfiguration();
	}

	/**
	 * @return Conditions
	 */
	public function createConditions()
	{
		return $this->populate(new Conditions());
	}
}