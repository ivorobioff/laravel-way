<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\FeesController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Fees implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('companies/{companyId}/fees', FeesController::class.'@index');
        $registrar->put('companies/{companyId}/fees', FeesController::class.'@replace');
    }
}