<?php
namespace RealEstate\Core\Customer\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Customer\Services\DocumentSupportedFormatsService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeIsAvailableForDocumentSupportedFormats extends AbstractRule
{
	/**
	 * @var DocumentSupportedFormatsService
	 */
	private $formatsService;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var JobType
	 */
	private $ignoredJobType;

	/**
	 * @param DocumentSupportedFormatsService $formatsService
	 * @param Customer $customer
	 * @param JobType $ignoredJobType
	 */
	public function __construct(
		DocumentSupportedFormatsService $formatsService,
		Customer $customer,
		JobType $ignoredJobType = null
	)
	{
		$this->formatsService = $formatsService;
		$this->customer = $customer;
		$this->ignoredJobType = $ignoredJobType;

		$this->setIdentifier('already-taken');
		$this->setMessage('The supported document formats are already set for the specified job type.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		$ignored = null;

		if ($this->ignoredJobType !== null){
			$ignored = $this->ignoredJobType->getId();
		}

		if ($this->formatsService->hasWithJobType($this->customer->getId(), $value, $ignored)){
			return $this->getError();
		}

		return null;
	}
}