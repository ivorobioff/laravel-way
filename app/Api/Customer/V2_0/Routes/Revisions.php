<?php
namespace RealEstate\Api\Customer\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\RevisionsController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Revisions implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->resource('customers.orders.revisions', RevisionsController::class, ['only' => ['store', 'index']]);
	}
}