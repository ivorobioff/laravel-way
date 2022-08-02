<?php
namespace RealEstate\Core\Amc\Services;

use RealEstate\Core\Amc\Entities\FeeByZip;

class FeeByZipService extends AbstractFeeByZipService
{
    use UseFeeByStateTrait;
    use UseFeeTrait;

    /**
     * @return string
     */
    protected function getFeeByZipClass()
    {
        return FeeByZip::class;
    }
}
