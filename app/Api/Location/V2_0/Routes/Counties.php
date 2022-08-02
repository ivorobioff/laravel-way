<?php
namespace RealEstate\Api\Location\V2_0\Routes;

use Restate\Libraries\Routing\Router;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Location\V2_0\Controllers\CountiesController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Counties implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface|Router $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->get(
			'location/states/{stateCode}/counties',
			CountiesController::class.'@index'
		)->where('stateCode', '...state');


		$registrar->get(
			'location/states/{stateCode}/counties/{county}',
			CountiesController::class.'@show'
		)->where('stateCode', '...state');
	}
}