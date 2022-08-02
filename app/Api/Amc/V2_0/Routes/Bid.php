<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\BidController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Bid implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->post('amcs/{amcId}/orders/{orderId}/bid', BidController::class.'@store');
        $registrar->get('amcs/{amcId}/orders/{orderId}/bid', BidController::class.'@show');
    }
}