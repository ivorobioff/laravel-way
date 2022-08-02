<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\LogsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Logs implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->get('appraisers/{appraiserId}/logs', LogsController::class.'@index');
		$registrar->get('appraisers/{appraiserId}/orders/{orderId}/logs', LogsController::class.'@indexByOrder');
	}
}