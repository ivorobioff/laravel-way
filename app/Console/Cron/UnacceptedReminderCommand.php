<?php
namespace RealEstate\Console\Cron;
use RealEstate\Core\Appraisal\Services\ReminderService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UnacceptedReminderCommand extends AbstractCommand
{
    /**
     * @param ReminderService $reminderService
     */
    public function handle(ReminderService $reminderService)
    {
        $reminderService->handleAllUnacceptedOrders();
    }
}