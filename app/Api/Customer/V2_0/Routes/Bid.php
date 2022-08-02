<?php
namespace RealEstate\Api\Customer\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\BidController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Bid implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->post('customers/{customerId}/orders/{orderId}/bid', BidController::class.'@store');
		$registrar->patch('customers/{customerId}/orders/{orderId}/bid', BidController::class.'@update');
		$registrar->get('customers/{customerId}/orders/{orderId}/bid', BidController::class.'@show');
	}
}