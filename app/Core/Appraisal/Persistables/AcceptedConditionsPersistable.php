<?php
namespace RealEstate\Core\Appraisal\Persistables;

use RealEstate\Core\Appraisal\Objects\Conditions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptedConditionsPersistable extends Conditions
{
	/**
	 * @var string
	 */
	private $additionalComments;
	public function setAdditionalComments($comments) { $this->additionalComments = $comments; }
	public function getAdditionalComments() { return $this->additionalComments; }}