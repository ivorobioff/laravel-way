<?php
namespace RealEstate\Core\Amc\Persistables;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeByStatePersistable
{
    /**
     * @var string
     */
    private $state;
    public function setState($state) { $this->state = $state; }
    public function getState() { return $this->state; }

    /**
     * @var float
     */
    private $amount;
    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }
}