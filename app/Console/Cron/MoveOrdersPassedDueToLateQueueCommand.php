<?php
namespace RealEstate\Console\Cron;
use RealEstate\Core\Appraisal\Services\OrderService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MoveOrdersPassedDueToLateQueueCommand extends AbstractCommand
{
    /**
     * @param OrderService $orderService
     */
    public function fire(OrderService $orderService)
    {
        $this->startSystemSession();

        $orderService->moveAllPassedDueToLateQueue();

        $this->endSystemSession();
    }
}