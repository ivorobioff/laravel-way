<?php
namespace RealEstate\Api\Company\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Company\V2_0\Controllers\QueuesController;
use RealEstate\Core\Appraisal\Enums\Queue;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Queues implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'managers/{managerId}/queues/{name}',
            QueuesController::class.'@index'
        )->where('name', '('.implode('|', Queue::toArray()).')');


        $registrar->get(
            'managers/{managerId}/queues/counters',
            QueuesController::class.'@counters'
        );
    }
}