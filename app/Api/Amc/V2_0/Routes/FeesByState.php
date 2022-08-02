<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Restate\Libraries\Routing\Router;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\CustomerFeesByStateController;
use RealEstate\Api\Amc\V2_0\Controllers\FeesByStateController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByState implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface|Router $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('amcs/{amcId}/fees/{jobTypeId}/states', FeesByStateController::class.'@index');
        $registrar->put('amcs/{amcId}/fees/{jobTypeId}/states', FeesByStateController::class.'@sync');

        $registrar->patch(
            'amcs/{amcId}/fees/{jobTypeId}/states/{code}', FeesByStateController::class.'@update')
            ->where('code', '...state');

        $registrar->get(
            'amcs/{amcId}/customers/{customerId}/fees/{jobTypeId}/states',
            CustomerFeesByStateController::class.'@index'
        );
        $registrar->put(
            'amcs/{amcId}/customers/{customerId}/fees/{jobTypeId}/states',
            CustomerFeesByStateController::class.'@sync'
        );
        $registrar->patch(
            'amcs/{amcId}/customers/{customerId}/fees/{jobTypeId}/states/{code}',
            CustomerFeesByStateController::class.'@update'
        )->where('code', '...state');
    }
}