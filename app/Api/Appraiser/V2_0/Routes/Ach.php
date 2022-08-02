<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\AchController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Ach implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->get('appraisers/{appraiserId}/ach', AchController::class.'@show');
		$registrar->put('appraisers/{appraiserId}/ach', AchController::class.'@replace');
	}
}