<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Restate\Libraries\Routing\Router;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\CustomerFeesByCountyController;
use RealEstate\Api\Amc\V2_0\Controllers\FeesByCountyController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByCounty implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface|Router $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'amcs/{amcId}/fees/{jobTypeId}/states/{code}/counties',
            FeesByCountyController::class.'@index'
        )->where('code', '...state');

        $registrar->put(
            'amcs/{amcId}/fees/{jobTypeId}/states/{code}/counties',
            FeesByCountyController::class.'@sync'
        )->where('code', '...state');


        $registrar->get(
            'amcs/{amcId}/customers/{customerId}/fees/{feeId}/states/{code}/counties',
            CustomerFeesByCountyController::class.'@index'
        )->where('code', '...state');

        $registrar->put(
            'amcs/{amcId}/customers/{customerId}/fees/{feeId}/states/{code}/counties',
            CustomerFeesByCountyController::class.'@sync'
        )->where('code', '...state');
    }
}