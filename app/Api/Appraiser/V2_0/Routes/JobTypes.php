<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\JobTypesController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypes implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->resource(
			'appraisers.customers.job-types',
			JobTypesController::class,
			['only' => 'index']
		);
	}
}