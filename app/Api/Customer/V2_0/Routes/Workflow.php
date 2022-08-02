<?php
namespace RealEstate\Api\Customer\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\WorkflowController;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Workflow implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$values = ProcessStatus::toArray();

		foreach ($values as $value){
			$registrar->post(
				'customers/{customerId}/orders/{ordersId}/workflow/'.$value,
				WorkflowController::class.'@'.camel_case($value === 'new' ? 'fresh' : $value)
			);
		}
	}
}