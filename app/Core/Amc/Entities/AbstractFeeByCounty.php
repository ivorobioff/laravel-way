<?php
namespace RealEstate\Core\Amc\Entities;
use RealEstate\Core\Location\Entities\County;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractFeeByCounty
{
    /**
     * @var int
     */
    protected $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var County
     */
    protected $county;
    public function setCounty(County $county) { $this->county = $county; }
    public function getCounty() { return $this->county; }

    /**
     * @var float
     */
    protected $amount;
    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }
}