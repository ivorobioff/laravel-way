<?php
namespace RealEstate\Core\JobType\Properties;

use RealEstate\Core\JobType\Entities\JobType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait JobTypePropertyTrait
{
	/**
	 * @var JobType
	 */
	private $jobType;

	/**
	 * @param JobType $jobType
	 */
	public function setJobType(JobType $jobType)
	{
		$this->jobType = $jobType;
	}

	/**
	 * @return JobType
	 */
	public function getJobType()
	{
		return $this->jobType;
	}
}