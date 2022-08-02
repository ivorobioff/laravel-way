<?php
namespace RealEstate\Core\Appraisal\Objects;

use RealEstate\Core\Appraisal\Enums\Request;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Conditions
{
	/**
	 * @var Request
	 */
	protected $request;
	public function getRequest() { return $this->request; }
	public function setRequest(Request $request) { $this->request = $request; }

	/**
	 * @var float
	 */
	protected $fee;
	public function setFee($fee) { $this->fee = $fee; }
	public function getFee() { return $this->fee; }

	/**
	 * @var DateTime
	 */
	protected $dueDate;
	public function getDueDate() { return $this->dueDate; }
	public function setDueDate(DateTime $dueDate) { $this->dueDate = $dueDate; }

	/**
	 * @var string
	 */
	protected $explanation;
	public function setExplanation($explanation) { $this->explanation = $explanation; }
	public function getExplanation() { return $this->explanation; }
}