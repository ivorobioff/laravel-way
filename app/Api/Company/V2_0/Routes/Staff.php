<?php
namespace RealEstate\Api\Company\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\StaffController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Staff implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('companies.staff', StaffController::class, ['only' => ['index', 'show', 'update', 'destroy']]);

        $registrar->post('companies/{companyId}/managers', StaffController::class.'@storeManager');
        $registrar->get('companies/{companyId}/branches/{branchId}/staff', StaffController::class.'@indexByBranch');
    }
}