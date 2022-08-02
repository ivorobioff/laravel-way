<?php
namespace RealEstate\Core\Appraisal\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RevisionPersistable
{
	/**
	 * @var array
	 */
	private $checklist;
	public function setChecklist(array $checklist) { $this->checklist = $checklist; }
	public function getChecklist() { return $this->checklist; }

	/**
	 * @var string
	 */
	private $message;
	public function setMessage($message) { $this->message = $message; }
	public function getMessage() { return $this->message; }
}