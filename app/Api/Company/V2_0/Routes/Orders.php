<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\OrdersController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Orders implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('managers/{managerId}/orders', OrdersController::class.'@index');
        $registrar->get('managers/{managerId}/orders/{orderId}', OrdersController::class.'@show');

        $registrar->post('managers/{managerId}/orders/{orderId}/accept', OrdersController::class.'@accept');

        $registrar->post(
            'managers/{managerId}/orders/{orderId}/accept-with-conditions',
            OrdersController::class.'@acceptWithConditions'
        );

        $registrar->post('managers/{managerId}/orders/{orderId}/decline', OrdersController::class.'@decline');
        $registrar->post('managers/{managerId}/orders/{orderId}/reassign', OrdersController::class.'@reassign');

        $registrar->post('managers/{managerId}/orders/{orderId}/change-additional-status',
            OrdersController::class.'@changeAdditionalStatus');

        $registrar->get('managers/{managerId}/orders/{orderId}/additional-statuses',
            OrdersController::class.'@listAdditionalStatuses');
    }
}