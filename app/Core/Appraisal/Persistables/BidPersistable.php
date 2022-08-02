<?php
namespace RealEstate\Core\Appraisal\Persistables;

use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidPersistable
{
	/**
	 * @var float
	 */
	private $amount;
	public function getAmount() { return $this->amount; }
	public function setAmount($amount) { $this->amount = $amount; }

	/**
	 * @var DateTime
	 */
	private $estimatedCompletionDate;
	public function setEstimatedCompletionDate(DateTime $datetime = null) { $this->estimatedCompletionDate = $datetime; }
	public function getEstimatedCompletionDate() { return $this->estimatedCompletionDate; }

	/**
	 * @var string
	 */
	private $comments;
	public function setComments($comments) { $this->comments = $comments; }
	public function getComments() { return $this->comments; }
}