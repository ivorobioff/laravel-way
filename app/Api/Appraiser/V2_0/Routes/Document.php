<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\DocumentController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Document implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->get(
			'appraisers/{appraiserId}/orders/{orderId}/document/formats',
			DocumentController::class.'@formats'
		);

		$registrar->post(
			'appraisers/{appraiserId}/orders/{orderId}/document',
			DocumentController::class.'@store'
		);

		$registrar->get(
			'appraisers/{appraiserId}/orders/{orderId}/document',
			DocumentController::class.'@show'
		);

		$registrar->patch(
			'appraisers/{appraiserId}/orders/{orderId}/document',
			DocumentController::class.'@update'
		);

		$registrar->post(
			'appraisers/{appraiserId}/orders/{orderId}/document/email',
			DocumentController::class.'@email'
		);
	}
}