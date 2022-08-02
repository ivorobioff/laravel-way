<?php
namespace RealEstate\Core\Amc\Entities;

use RealEstate\Core\Assignee\Entities\CustomerFee;

class CustomerFeeByCounty extends AbstractFeeByCounty
{
    /**
     * @var CustomerFee
     */
    private $fee;
    public function setFee(CustomerFee $fee) { $this->fee = $fee; }
    public function getFee() { return $this->fee; }
}
