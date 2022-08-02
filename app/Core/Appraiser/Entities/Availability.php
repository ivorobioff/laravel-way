<?php
namespace RealEstate\Core\Appraiser\Entities;

use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Availability
{
	/**
	 * @var int
	 */
	private $id;
	public function setId($id) { $this->id = $id; }
	public function getId() { return $this->id; }

	/**
	 * @var bool
	 */
	private $isOnVacation;
	public function setOnVacation($flag) { $this->isOnVacation = $flag; }
	public function isOnVacation() { return $this->isOnVacation; }

	/**
	 * @var DateTime
	 */
	private $from;
	public function getFrom() { return $this->from; }
	public function setFrom(DateTime $from = null) { $this->from = $from; }

	/**
	 * @var DateTime
	 */
	private $to;
	public function getTo() { return $this->to; }
	public function setTo(DateTime $to = null) { $this->to = $to; }

	/**
	 * @var string
	 */
	private $message;
	public function setMessage($message) { $this->message = $message; }
	public function getMessage() { return $this->message; }

	public function __construct()
	{
		$this->setOnVacation(false);
	}
}