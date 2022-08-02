<?php
namespace RealEstate\Core\Invitation\Notifications;

use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Invitation\Entities\Invitation;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptInvitationNotification extends AbstractNotification
{
	/**
	 * @var Appraiser $appraiser
	 */
	private $appraiser;

	/**
	 * @param Invitation $invitation
	 * @param Appraiser $appraiser
	 */
	public function __construct(Invitation $invitation, Appraiser $appraiser)
	{
		parent::__construct($invitation);
		$this->appraiser = $appraiser;
	}

	/**
	 * @return Appraiser
	 */
	public function getAppraiser()
	{
		return $this->appraiser;
	}
}