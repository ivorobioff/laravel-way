<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use RealEstate\Core\Appraisal\Validation\Rules\InspectionDate;
use DateTime;
use RealEstate\Core\Customer\Entities\Settings;
use RealEstate\Core\Customer\Enums\Criticality;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InspectionValidator extends AbstractThrowableValidator
{
	/**
	 * @var DateTime
	 */
	private $dueDate;

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * @var bool
	 */
	private $isOccurredAlready;

	/**
	 * @var EnvironmentInterface
	 */
	private $environment;

    /**
     * @var bool
     */
    private $bypassDatesValidation = false;

	/**
	 * @param DateTime $dueDate (the argument is meant to a nullable and not an optional)
	 * @param Settings $settings
	 * @param bool $isOccurredAlready
	 * @param EnvironmentInterface $environment
	 */
	public function __construct(
		DateTime $dueDate = null,
		Settings $settings,
		$isOccurredAlready,
		EnvironmentInterface $environment
	)
	{
		$this->dueDate = $dueDate;
		$this->settings = $settings;
		$this->isOccurredAlready = $isOccurredAlready;
		$this->environment = $environment;
	}

	/**
	 * @param Binder $binder
	 */
	protected function define(Binder $binder)
	{
		if ($this->environment->isRelaxed()
            || $this->bypassDatesValidation === true
			|| !$this->settings->getPreventViolationOfDateRestrictions()->is(Criticality::HARDSTOP)){
			return ;
		}

		if ($this->dueDate !== null){
			$binder->bind('estimatedCompletionDate', function(Property $property){
				$property
					->addRule((new InspectionDate($this->settings->getDaysPriorEstimatedCompletionDate()))->setDueDate($this->dueDate));
			});

			if ($this->isOccurredAlready){
				$field = 'completedAt';
			} else {
				$field = 'scheduledAt';
			}

			$binder->bind($field, function(Property $property){
				$property
					->addRule((new InspectionDate($this->settings->getDaysPriorInspectionDate()))->setDueDate($this->dueDate));
			});
		}
	}

    /**
     * @param bool $flag
     * @return $this
     */
	public function setBypassDatesValidation($flag)
    {
        $this->bypassDatesValidation = $flag;
        return $this;
    }
}