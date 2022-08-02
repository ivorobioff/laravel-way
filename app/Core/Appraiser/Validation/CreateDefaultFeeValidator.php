<?php
namespace RealEstate\Core\Appraiser\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Appraiser\Validation\Rules\JobTypeAvailableForDefaultFee;
use RealEstate\Core\Assignee\Validation\AbstractFeeValidator;
use RealEstate\Core\JobType\Services\JobTypeService;
use RealEstate\Core\JobType\Validation\Rules\JobTypeExists;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateDefaultFeeValidator extends AbstractFeeValidator
{
	/**
	 * @var JobTypeService
	 */
	private $jobTypeService;

	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @var Appraiser
	 */
	private $appraiser;

	public function __construct(ContainerInterface $container, Appraiser $appraiser)
	{
		$this->appraiser = $appraiser;

		$this->jobTypeService = $container->get(JobTypeService::class);
		$this->appraiserService = $container->get(AppraiserService::class);
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
				->addRule(new JobTypeExists($this->jobTypeService))
				->addRule(new JobTypeAvailableForDefaultFee($this->appraiserService, $this->appraiser));
		});

		$this->defineAmount($binder);
	}
}