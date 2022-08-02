<?php
namespace RealEstate\Core\Appraisal\Emails;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Support\Letter\Email;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UnacceptedReminderEmail extends Email
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}