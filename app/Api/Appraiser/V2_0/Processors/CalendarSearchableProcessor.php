<?php
namespace RealEstate\Api\Appraiser\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Rules\Moment;
use DateTime;
use RealEstate\Core\Support\Criteria\Day;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CalendarSearchableProcessor extends AbstractProcessor
{
	/**
	 * @return DateTime
	 */
	public function getFrom()
	{
		$datetime = $this->get('from');

		if ((new Moment('Y-m-d'))->check($datetime)){
			return null;
		}

		return new Day($datetime);
	}

	/**
	 * @return DateTime
	 */
	public function getTo()
	{
		$datetime = $this->get('to');

		if ((new Moment('Y-m-d'))->check($datetime)){
			return null;
		}

		return new Day($datetime);
	}
}