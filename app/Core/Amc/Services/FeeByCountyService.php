<?php
namespace RealEstate\Core\Amc\Services;

use RealEstate\Core\Amc\Entities\FeeByCounty;

class FeeByCountyService extends AbstractFeeByCountyService
{
    use UseFeeByStateTrait;
    use UseFeeTrait;

    /**
     * @return string
     */
    protected function getFeeByCountyClass()
    {
        return FeeByCounty::class;
    }
}
