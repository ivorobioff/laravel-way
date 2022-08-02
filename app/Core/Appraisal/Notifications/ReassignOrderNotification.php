<?php
namespace RealEstate\Core\Appraisal\Notifications;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReassignOrderNotification extends AbstractNotification
{
    /**
     * @var User
     */
    private $oldAssignee;

    /**
     * @param Order $order
     * @param User $oldAssignee
     */
    public function __construct(Order $order, User $oldAssignee)
    {
        parent::__construct($order);

        $this->oldAssignee = $oldAssignee;
    }

    /**
     * @return User
     */
    public function getOldAssignee()
    {
        return $this->oldAssignee;
    }
}