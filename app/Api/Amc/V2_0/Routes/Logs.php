<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\LogsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Logs implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('amcs/{amcId}/logs', LogsController::class.'@index');
        $registrar->get('amcs/{amcId}/logs/{logId}', LogsController::class.'@show');
        $registrar->get('amcs/{amcId}/orders/{orderId}/logs', LogsController::class.'@indexByOrder');
    }
}