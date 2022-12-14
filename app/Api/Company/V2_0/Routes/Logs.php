<?php
namespace RealEstate\Api\Company\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\LogsController;

class Logs implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('managers/{managerId}/logs', LogsController::class.'@index');
        $registrar->get(
            'managers/{managerId}/orders/{orderId}/logs',
            LogsController::class.'@indexByOrder'
        );
    }
}
