<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\CreditCardController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreditCard implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->put('amcs/{amcId}/payment/credit-card', CreditCardController::class.'@replace');
        $registrar->get('amcs/{amcId}/payment/credit-card', CreditCardController::class.'@show');
    }
}