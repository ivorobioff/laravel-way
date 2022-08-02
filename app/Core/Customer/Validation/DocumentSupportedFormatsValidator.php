<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Customer\Services\DocumentSupportedFormatsService;
use RealEstate\Core\Customer\Validation\Rules\JobTypeBelongs;
use RealEstate\Core\Customer\Validation\Rules\JobTypeIsAvailableForDocumentSupportedFormats;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormatsValidator extends AbstractThrowableValidator
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

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
	 * @param CustomerService $customerService
	 * @param DocumentSupportedFormatsService $formatsService
	 * @param Customer $customer
	 */
	public function __construct(
		CustomerService $customerService,
		DocumentSupportedFormatsService $formatsService,
		Customer $customer
	)
	{
		$this->customerService = $customerService;
		$this->formatsService = $formatsService;
		$this->customer = $customer;
	}

	/**
	 * @param JobType $jobType
	 * @return $this
	 */
	public function ignoreJobType(JobType $jobType)
	{
		$this->ignoredJobType = $jobType;
		return $this;
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('jobType', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new JobTypeBelongs($this->customerService, $this->customer))
				->addRule(new JobTypeIsAvailableForDocumentSupportedFormats(
					$this->formatsService,
					$this->customer,
					$this->ignoredJobType
				));
		});

		$binder->bind('primary', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});
	}
}