<?php
namespace RealEstate\Core\JobType\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\JobType\Services\JobTypeService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeExists extends AbstractRule
{
	/**
	 * @var JobTypeService
	 */
	private $jobTypeService;

	/**
	 * @param JobTypeService $jobTypeService
	 */
	public function __construct(JobTypeService $jobTypeService)
	{
		$this->jobTypeService = $jobTypeService;

		$this->setIdentifier('exists');
		$this->setMessage('The job type does not exist.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (!$this->jobTypeService->exists($value)){
			return $this->getError();
		}

		return null;
	}
}