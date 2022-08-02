<?php
namespace RealEstate\Api\Customer\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\CompaniesController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Companies implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->post(
            '/customers/{customerId}/companies/{companyId}/staff/{staffId}/orders',
            CompaniesController::class.'@storeOrder'
        );
    }
}