<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Restate\Libraries\Routing\Router;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\QueuesController;
use RealEstate\Core\Appraisal\Enums\Queue;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Queues implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface|Router $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->get(
			'appraisers/{appraiserId}/queues/{name}',
			QueuesController::class.'@index'
		)->where('name', '('.implode('|', Queue::toArray()).')');


		$registrar->get(
			'appraisers/{appraiserId}/queues/counters',
			QueuesController::class.'@counters'
		);
	}
}