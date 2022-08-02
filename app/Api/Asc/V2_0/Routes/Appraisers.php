<?php
namespace RealEstate\Api\Asc\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Asc\V2_0\Controllers\AppraisersController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Appraisers implements RouteRegistrarInterface
{

    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('asc', AppraisersController::class, [
            'only' => 'index'
        ]);
    }
}