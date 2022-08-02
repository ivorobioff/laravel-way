<?php
namespace RealEstate\Api\Document\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Document\V2_0\Controllers\DocumentsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Documents implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
		$registrar->post('/documents', DocumentsController::class.'@store');
		$registrar->post('/documents/external', DocumentsController::class.'@storeExternal');
    }
}