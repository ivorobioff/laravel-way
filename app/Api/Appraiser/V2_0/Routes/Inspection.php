<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\InspectionController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Inspection implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->post(
			'appraisers/{appraiserId}/orders/{orderId}/schedule-inspection',
			InspectionController::class.'@schedule'
		);

		$registrar->post(
			'appraisers/{appraiserId}/orders/{orderId}/complete-inspection',
			InspectionController::class.'@complete'
		);
	}
}