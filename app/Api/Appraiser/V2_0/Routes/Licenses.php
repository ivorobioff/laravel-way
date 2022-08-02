<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\LicensesController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Licenses implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('appraisers.licenses', LicensesController::class);
    }
}