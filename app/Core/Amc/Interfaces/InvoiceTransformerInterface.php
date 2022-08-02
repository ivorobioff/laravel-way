<?php
namespace RealEstate\Core\Amc\Interfaces;
use RealEstate\Core\Amc\Entities\Invoice;
use RealEstate\Core\Document\Persistables\DocumentPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface InvoiceTransformerInterface
{
    /**
     * @param Invoice $invoice
     * @return DocumentPersistable
     */
    public function toPdf(Invoice $invoice);
}