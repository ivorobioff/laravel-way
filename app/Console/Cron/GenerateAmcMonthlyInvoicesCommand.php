<?php
namespace RealEstate\Console\Cron;
use RealEstate\Core\Amc\Services\InvoiceService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class GenerateAmcMonthlyInvoicesCommand extends AbstractCommand
{
    /**
     * @param InvoiceService $invoiceService
     */
    public function fire(InvoiceService $invoiceService)
    {
        $invoiceService->generateMonthlyInvoices();
    }
}