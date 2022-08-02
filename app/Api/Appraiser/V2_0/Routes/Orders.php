<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\OrdersController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Orders implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->resource('appraisers.orders', OrdersController::class, ['only' => ['index', 'show']]);

		$registrar->post('appraisers/{appraiserId}/orders/{orderId}/accept', OrdersController::class.'@accept');

		$registrar->post(
			'appraisers/{appraiserId}/orders/{orderId}/accept-with-conditions',
			OrdersController::class.'@acceptWithConditions'
		);

		$registrar->post('appraisers/{appraiserId}/orders/{orderId}/decline', OrdersController::class.'@decline');

		$registrar->post('appraisers/{appraiserId}/orders/{orderId}/pay-tech-fee', OrdersController::class.'@pay');

		$registrar->get('appraisers/{appraiserId}/orders/totals', OrdersController::class.'@totals');

		$registrar->post('appraisers/{appraiserId}/orders/{orderId}/change-additional-status',
			OrdersController::class.'@changeAdditionalStatus');

		$registrar->get('appraisers/{appraiserId}/orders/{orderId}/additional-statuses',
			OrdersController::class.'@listAdditionalStatuses');
	}
}