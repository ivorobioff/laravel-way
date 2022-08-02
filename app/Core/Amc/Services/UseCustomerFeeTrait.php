<?php
namespace RealEstate\Core\AMc\Services;

use RealEstate\Core\Assignee\Entities\CustomerFee;

trait UseCustomerFeeTrait
{
    /**
     * @return string
     */
    protected function getFeeClass()
    {
        return CustomerFee::class;
    }
}
