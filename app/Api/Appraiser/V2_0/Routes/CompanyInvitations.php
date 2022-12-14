<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\CompanyInvitationsController;

class CompanyInvitations implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('appraisers/{appraiserId}/company-invitations', CompanyInvitationsController::class.'@index');
        $registrar->post(
            'appraisers/{appraiserId}/company-invitations/{companyInvitationId}/accept',
            CompanyInvitationsController::class.'@accept'
        );
        $registrar->post(
            'appraisers/{appraiserId}/company-invitations/{companyInvitationId}/decline',
            CompanyInvitationsController::class.'@decline'
        );
    }
}
