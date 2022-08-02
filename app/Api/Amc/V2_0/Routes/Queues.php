<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\Router;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\QueuesController;
use RealEstate\Core\Appraisal\Enums\Queue;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Queues implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface|Router $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar
            ->get('amcs/{amcId}/queues/{name}', QueuesController::class.'@index')
            ->where('name', '('.implode('|', Queue::toArray()).')');
        
        $registrar->get('amcs/{amcId}/queues/counters',  QueuesController::class.'@counters');
    }
}