<?php
namespace RealEstate\Api\Customer\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\AmcsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Amcs implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('customers/{customerId}/amcs', AmcsController::class.'@index');
        $registrar->post('customers/{customerId}/amcs/{amcId}/orders', AmcsController::class.'@storeOrder');

    }
}