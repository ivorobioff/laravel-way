<?php
namespace RealEstate\Api\Customer\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\AppraiserQueuesController;
use RealEstate\Core\Appraisal\Enums\Queue;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserQueues implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'customers/{customerId}/appraisers/{appraiserId}/queues/{name}',
            AppraiserQueuesController::class.'@index'
        )->where('name', '('.implode('|', Queue::toArray()).')');


        $registrar->get(
            'customers/{customerId}/appraisers/{appraiserId}/queues/counters',
            AppraiserQueuesController::class.'@counters'
        );
    }
}