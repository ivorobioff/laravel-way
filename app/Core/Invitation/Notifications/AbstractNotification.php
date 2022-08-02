<?php
namespace RealEstate\Core\Invitation\Notifications;

use RealEstate\Core\Invitation\Entities\Invitation;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractNotification
{
	/**
	 * @var Invitation
	 */
	private $invitation;

	/**
	 * @param Invitation $invitation
	 */
	public function __construct(Invitation $invitation)
	{
		$this->invitation = $invitation;
	}

	/**
	 * @return Invitation
	 */
	public function getInvitation()
	{
		return $this->invitation;
	}
}