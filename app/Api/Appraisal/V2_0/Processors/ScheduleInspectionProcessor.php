<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Moment;
use Restate\Libraries\Validation\Rules\Obligate;
use DateTime;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ScheduleInspectionProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('scheduledAt', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Moment());
		});

		$binder->bind('estimatedCompletionDate', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Moment());
		});
	}

	protected function allowable()
	{
		return ['scheduledAt', 'estimatedCompletionDate'];
	}

	/**
	 * @return DateTime
	 */
	public function getScheduledAt()
	{
		return Shortcut::utc($this->get('scheduledAt'));
	}

	/**
	 * @return DateTime
	 */
	public function getEstimatedCompletionDate()
	{
		return Shortcut::utc($this->get('estimatedCompletionDate'));
	}
}