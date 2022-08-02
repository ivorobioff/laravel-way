<?php
namespace RealEstate\Console\Cron;
use RealEstate\Support\Chance\Coordinator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TryAllAttemptsCommand extends AbstractCommand
{
    /**
     * @param Coordinator $coordinator
     */
    public function fire(Coordinator $coordinator)
    {
        $coordinator->tryAllAttempts();
    }
}