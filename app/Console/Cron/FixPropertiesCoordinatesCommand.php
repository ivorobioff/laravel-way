<?php
namespace RealEstate\Console\Cron;
use RealEstate\Core\Appraisal\Services\OrderService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FixPropertiesCoordinatesCommand extends AbstractCommand
{
    /**
     * @param OrderService $orderService
     */
    public function fire(OrderService $orderService)
    {
        $orderService->fixPropertiesCoordinates();
    }
}