<?php
namespace RealEstate\Core\Amc\Services;

use RealEstate\Core\Amc\Entities\Fee;

trait UseFeeTrait
{
    /**
     * @return string
     */
    protected function getFeeClass()
    {
        return Fee::class;
    }
}
