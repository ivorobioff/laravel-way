<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\DocumentController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'amcs/{amcId}/orders/{orderId}/document/formats',
            DocumentController::class.'@formats'
        );

        $registrar->post(
            'amcs/{amcId}/orders/{orderId}/document',
            DocumentController::class.'@store'
        );

        $registrar->get(
            'amcs/{amcId}/orders/{orderId}/document',
            DocumentController::class.'@show'
        );

        $registrar->patch(
            'amcs/{amcId}/orders/{orderId}/document',
            DocumentController::class.'@update'
        );
    }
}