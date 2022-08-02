<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\ReconsiderationsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Reconsiderations implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('managers.orders.reconsiderations', ReconsiderationsController::class, ['only' => ['index']]);
    }
}