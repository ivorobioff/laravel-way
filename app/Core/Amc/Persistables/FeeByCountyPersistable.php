<?php
namespace RealEstate\Core\Amc\Persistables;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeByCountyPersistable
{
    /**
     * @var int
     */
    private $county;
    public function setCounty($county) { $this->county = $county; }
    public function getCounty() { return $this->county; }

    /**
     * @var float
     */
    private $amount;
    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }
}