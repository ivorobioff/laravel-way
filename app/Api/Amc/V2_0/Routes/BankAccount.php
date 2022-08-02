<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\BankAccountController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BankAccount implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->put('amcs/{amcId}/payment/bank-account', BankAccountController::class.'@change');
        $registrar->get('amcs/{amcId}/payment/bank-account', BankAccountController::class.'@show');
    }
}