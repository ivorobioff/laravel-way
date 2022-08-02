<?php
namespace RealEstate\Core\Amc\Services;

use RealEstate\Core\Amc\Entities\CustomerFeeByState;

trait UseCustomerFeeByStateTrait
{
    /**
     * @return string
     */
    protected function getFeeByStateClass()
    {
        return CustomerFeeByState::class;
    }
}
