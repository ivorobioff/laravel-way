<?php
namespace RealEstate\Core\Amc\Services;

use RealEstate\Core\Amc\Entities\FeeByState;

trait UseFeeByStateTrait
{
    /**
     * @return string
     */
    protected function getFeeByStateClass()
    {
        return FeeByState::class;
    }
}
