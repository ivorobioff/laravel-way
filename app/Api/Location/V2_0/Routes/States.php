<?php
namespace RealEstate\Api\Location\V2_0\Routes;

use Restate\Libraries\Routing\Router;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Location\V2_0\Controllers\StatesController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class States implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface|Router $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('/location/states', StatesController::class, [
            'only' => 'index'
        ]);

        $registrar->get('/location/states/{code}/zips', StatesController::class.'@zips')
            ->where('code', '...state');
    }
}