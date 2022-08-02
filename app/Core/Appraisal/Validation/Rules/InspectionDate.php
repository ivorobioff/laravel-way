<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Less;
use Restate\Libraries\Validation\Value;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InspectionDate extends AbstractRule
{
	/**
	 * @var DateTime
	 */
	private $dueDate;

	/**
	 * @var int
	 */
	private $days;

	/**
	 * @param int $days
	 */
	public function __construct($days)
	{
		$this->days = $days;

		$this->setIdentifier('limit');
		$this->setMessage('The date must be less than the due date with subtracted days if any.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
	    if ($value instanceof Value){
	        list($dueDate, $value) = $value->extract();
        } else {
            $dueDate = $this->dueDate;
        }

		$dueDate = new DateTime($dueDate->format(DateTime::ATOM));
		$dueDate->modify('-'.$this->days.' days');

		if ((new Less($dueDate))->check($value)){
			return $this->getError();
		}

		return null;
	}

    /**
     * @param DateTime $datetime
     * @return $this
     */
	public function setDueDate(DateTime $datetime)
    {
        $this->dueDate = $datetime;
        return $this;
    }
}