<?php
namespace RealEstate\Api\Back\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Back\V2_0\Controllers\AdminsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Admins implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('admins', AdminsController::class, ['except' => ['index', 'destroy']]);
    }
}