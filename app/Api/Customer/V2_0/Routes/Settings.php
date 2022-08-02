<?php
namespace RealEstate\Api\Customer\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\SettingsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Settings implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->patch('customers/{customerId}/settings', SettingsController::class.'@update');
		$registrar->get('customers/{customerId}/settings', SettingsController::class.'@show');
	}
}