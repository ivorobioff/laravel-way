<?php
namespace RealEstate\Push\Handlers\Customer\Invitation;

use RealEstate\Core\Invitation\Notifications\DeclineInvitationNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeclineInvitationHandler extends BaseHandler
{
	/**
	 * @param DeclineInvitationNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'invitation',
			'event' => 'decline',
			'invitation' => $notification->getInvitation()->getId()
		];
	}
}