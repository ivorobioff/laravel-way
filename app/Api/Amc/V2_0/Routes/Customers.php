<?php
namespace RealEstate\Api\Amc\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\CustomersController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Customers implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('amcs.customers', CustomersController::class, ['only' => ['index']]);

        $registrar->get(
            '/amcs/{amcId}/customers/{customerId}/additional-statuses',
            CustomersController::class.'@listAdditionalStatuses'
        );

        $registrar->get(
            '/amcs/{amcId}/customers/{customerId}/additional-documents/types',
            CustomersController::class.'@listAdditionalDocumentsTypes'
        );
    }
}
