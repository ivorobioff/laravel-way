<?php
namespace RealEstate\Letter\Support;

use RealEstate\Core\Appraisal\Entities\Order;
use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Frequency
{
    /**
     * @var int
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var string
     */
    private $alias;
    public function setAlias($alias) { $this->alias = $alias; }
    public function getAlias() { return $this->alias; }

    /**
     * @var Order
     */
    private $order;
    public function setOrder(Order $order) { $this->order = $order; }
    public function getOrder() { return $this->order; }

    /**
     * @var DateTime
     */
    private $updatedAt;
    public function setUpdatedAt(DateTime $datetime) { $this->updatedAt = $datetime; }
    public function getUpdatedAt() { return $this->updatedAt; }

    public function __construct()
    {
        $this->updatedAt = new DateTime();
    }
}