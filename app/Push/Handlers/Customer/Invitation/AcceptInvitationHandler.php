<?php
namespace RealEstate\Push\Handlers\Customer\Invitation;

use RealEstate\Core\Invitation\Notifications\AcceptInvitationNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptInvitationHandler extends BaseHandler
{
	/**
	 * @param AcceptInvitationNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		return [
			'type' => 'invitation',
			'event' => 'accept',
			'invitation' => $notification->getInvitation()->getId(),
			'appraiser' => $notification->getAppraiser()->getId()
		];
	}
}