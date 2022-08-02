<?php
namespace RealEstate\Api\Customer\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\AppraiserOrdersController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserOrders implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->post('customers/{customerId}/appraisers/{appraiserId}/orders', AppraiserOrdersController::class.'@store');
        $registrar->get('customers/{customerId}/appraisers/{appraiserId}/orders', AppraiserOrdersController::class.'@index');
        $registrar->get(
            'customers/{customerId}/appraisers/{appraiserId}/orders/totals',
            AppraiserOrdersController::class.'@totals'
        );
    }
}