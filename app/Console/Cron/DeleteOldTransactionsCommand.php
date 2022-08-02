<?php
namespace RealEstate\Console\Cron;
use RealEstate\Core\Payment\Services\PaymentService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteOldTransactionsCommand extends AbstractCommand
{
    /**
     * @param PaymentService $paymentService
     */
    public function fire(PaymentService $paymentService)
    {
        $paymentService->deleteOldTransactions();
    }
}