<?php
namespace RealEstate\Core\Amc\Emails;
use RealEstate\Core\Amc\Entities\Invoice;
use RealEstate\Core\Support\Letter\Email;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceEmail extends Email
{
    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * InvoiceEmail constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}