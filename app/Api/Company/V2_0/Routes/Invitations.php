<?php
namespace RealEstate\Api\Company\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\InvitationsController;

class Invitations implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('companies/{companyId}/branches/{branchId}/invitations', InvitationsController::class.'@index');
        $registrar->post('companies/{companyId}/branches/{branchId}/invitations', InvitationsController::class.'@store');
    }
}
