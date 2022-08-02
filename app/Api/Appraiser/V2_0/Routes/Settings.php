<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\SettingsController;

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
		$registrar->get('appraisers/{appraiserId}/settings',
			SettingsController::class.'@show');

		$registrar->patch('appraisers/{appraiserId}/settings',
			SettingsController::class.'@update');
	}
}