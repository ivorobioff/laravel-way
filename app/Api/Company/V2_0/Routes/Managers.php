<?php
namespace RealEstate\Api\Company\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\ManagersController;

class Managers implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('managers', ManagersController::class, ['only' => ['show', 'update']]);
    }
}
