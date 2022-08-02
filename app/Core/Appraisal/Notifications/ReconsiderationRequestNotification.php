<?php
namespace RealEstate\Core\Appraisal\Notifications;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Reconsideration;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ReconsiderationRequestNotification extends AbstractNotification implements UpdateProcessStatusNotificationAwareInterface
{
    use UpdateProcessStatusNotificationAwareTrait;

    /**
     * @var Reconsideration
     */
    private $reconsideration;

    /**
     * @param Order $order
     * @param Reconsideration $reconsideration
     */
    public function __construct(Order $order, Reconsideration $reconsideration)
    {
        parent::__construct($order);

        $this->reconsideration = $reconsideration;
    }

    /**
     * @return Reconsideration
     */
    public function getReconsideration()
    {
        return $this->reconsideration;
    }
}