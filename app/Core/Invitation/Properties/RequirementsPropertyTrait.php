<?php
namespace RealEstate\Core\Invitation\Properties;

use RealEstate\Core\Invitation\Enums\Requirements;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait RequirementsPropertyTrait
{
	/**
	 * @var Requirements
	 */
	private $requirements;

	/**
	 * @return Requirements
	 */
	public function getRequirements()
	{
		return $this->requirements;
	}

	/**
	 * @param Requirements $requirements
	 */
	public function setRequirements(Requirements $requirements)
	{
		$this->requirements = $requirements;
	}
}