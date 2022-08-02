<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Invitation\Entities\Invitation;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateOrderNotification extends AbstractNotification
{
	/**
	 * @var Invitation
	 */
	private $invitation;

	/**
	 * @param Invitation $invitation
	 */
	public function withInvitation(Invitation $invitation)
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