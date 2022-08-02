<?php
namespace RealEstate\Api\Customer\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\OrdersController;

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
		$registrar->resource('customers.orders', OrdersController::class, ['except' => ['store', 'index']]);

		$registrar->post(
			'customers/{customerId}/orders/{orderId}/award',
			OrdersController::class.'@award'
		);

		$registrar->post(
			'customers/{customerId}/orders/{orderId}/change-additional-status',
			OrdersController::class.'@changeAdditionalStatus'
		);

        $registrar->post(
            'customers/{customerId}/orders/{orderId}/pay-off',
            OrdersController::class.'@payoff'
        );
	}
}