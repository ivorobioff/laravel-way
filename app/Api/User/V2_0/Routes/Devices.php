<?php
namespace RealEstate\Api\User\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\User\V2_0\Controllers\DevicesController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Devices implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->delete('users/{id}/devices/{deviceId}', DevicesController::class.'@destroy');
		$registrar->post('users/{id}/devices', DevicesController::class.'@store');
	}
}