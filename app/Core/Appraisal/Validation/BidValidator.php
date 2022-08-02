<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use DateTime;
use RealEstate\Core\Appraisal\Options\RequireEstimatedCompletionDateOptionTrait;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidValidator extends AbstractThrowableValidator
{
	use RequireEstimatedCompletionDateOptionTrait;

	/**
	 * @var EnvironmentInterface
	 */
	private $environment;

	/**
	 * @param EnvironmentInterface $environment
	 */
	public function __construct(EnvironmentInterface $environment)
	{
		$this->environment = $environment;
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('amount', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Greater(0));
		});

		$binder->bind('estimatedCompletionDate', function(Property $property){

			if ($this->isEstimatedCompletionDateRequired() && !$this->environment->isRelaxed()){
				$property->addRule(new Obligate());
			}

			if (!$this->environment->isRelaxed()){
				$property->addRule(new Greater(new DateTime()));
			}
		});

		$binder->bind('comments', function(Property $property){
			$property
				->addRule(new Length(1, 255));
		});
	}
}