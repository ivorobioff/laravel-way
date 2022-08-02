<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\DocumentController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Document implements RouteRegistrarInterface
{

    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'managers/{managerId}/orders/{orderId}/document/formats',
            DocumentController::class.'@formats'
        );

        $registrar->post(
            'managers/{managerId}/orders/{orderId}/document',
            DocumentController::class.'@store'
        );

        $registrar->get(
            'managers/{managerId}/orders/{orderId}/document',
            DocumentController::class.'@show'
        );

        $registrar->patch(
            'managers/{managerId}/orders/{orderId}/document',
            DocumentController::class.'@update'
        );
    }
}