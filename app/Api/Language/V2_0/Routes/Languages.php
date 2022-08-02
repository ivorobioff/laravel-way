<?php
namespace RealEstate\Api\Language\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Language\V2_0\Controllers\LanguagesController;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Languages implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('languages', LanguagesController::class, [
            'only' => 'index'
        ]);
    }
}