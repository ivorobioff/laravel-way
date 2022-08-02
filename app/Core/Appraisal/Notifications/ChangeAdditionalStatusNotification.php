<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Customer\Entities\AdditionalStatus;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusNotification extends AbstractNotification
{
	/**
	 * @var AdditionalStatus
	 */
	private $oldAdditionalStatus;

	/**
	 * @var strings
	 */
	private $oldAdditionalStatusComment;

	/**
	 * @var AdditionalStatus
	 */
	private $newAdditionalStatus;

	/**
	 * @var string
	 */
	private $newAdditionalStatusComment;

	/**
	 * @param AdditionalStatus $additionalStatus - the argument is nullable
	 * @param string $comment
	 */
	public function setOldAdditionalStatus(AdditionalStatus $additionalStatus = null, $comment = null)
	{
		$this->oldAdditionalStatus = $additionalStatus;
		$this->oldAdditionalStatusComment = $comment;
	}

	/**
	 * @param AdditionalStatus $additionalStatus - the argument is nullable
	 * @param string $comment
	 */
	public function setNewAdditionalStatus(AdditionalStatus $additionalStatus = null, $comment = null)
	{
		$this->newAdditionalStatus = $additionalStatus;
		$this->newAdditionalStatusComment = $comment;
	}

	/**
	 * @return AdditionalStatus
	 */
	public function getOldAdditionalStatus()
	{
		return $this->oldAdditionalStatus;
	}

	/**
	 * @return strings
	 */
	public function getOldAdditionalStatusComment()
	{
		return $this->oldAdditionalStatusComment;
	}

	/**
	 * @return AdditionalStatus
	 */
	public function getNewAdditionalStatus()
	{
		return $this->newAdditionalStatus;
	}

	/**
	 * @return string
	 */
	public function getNewAdditionalStatusComment()
	{
		return $this->newAdditionalStatusComment;
	}
}