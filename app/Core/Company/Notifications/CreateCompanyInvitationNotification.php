<?php
namespace RealEstate\Core\Company\Notifications;

use RealEstate\Core\Company\Entities\Invitation;

class CreateCompanyInvitationNotification
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
