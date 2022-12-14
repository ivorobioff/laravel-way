<?php
namespace RealEstate\Api\Company\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\PermissionsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Permissions implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('/companies/{companyId}/staff/{staffId}/permissions', PermissionsController::class.'@index');
        $registrar->put('/companies/{companyId}/staff/{staffId}/permissions', PermissionsController::class.'@replace');
    }
}