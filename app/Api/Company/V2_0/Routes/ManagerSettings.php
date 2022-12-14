<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\ManagerSettingsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ManagerSettings implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('managers/{managerId}/settings',
            ManagerSettingsController::class.'@show');

        $registrar->patch('managers/{managerId}/settings',
            ManagerSettingsController::class.'@update');
    }
}