<?php
namespace RealEstate\DAL\Amc\Support;
use Dompdf\Dompdf;
use RealEstate\Core\Amc\Entities\Invoice;
use RealEstate\Core\Amc\Entities\Item;
use RealEstate\Core\Amc\Interfaces\InvoiceTransformerInterface;
use RealEstate\Core\Document\Persistables\DocumentPersistable;
use Illuminate\View\Factory as View;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceTransformer implements InvoiceTransformerInterface
{
    /**
     * @var View
     */
    private $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param Invoice $invoice
     * @return DocumentPersistable
     */
    public function toPdf(Invoice $invoice)
    {
        $handler = new Dompdf();

        $handler->loadHtml($this->view->make('invoices.amc_tech_fee_invoice', $this->getData($invoice))->render());
        $handler->getOptions()->setIsHtml5ParserEnabled(true);
        $handler->render();

        $file = tmpfile();

        fwrite($file, $handler->output());

        $persistable = new DocumentPersistable();
        $persistable->setLocation($file);
        $persistable->setSuggestedName('Invoice-'.$invoice->getCreatedAt()->format('m-d-Y').'.pdf');

        return $persistable;
    }

    /**
     * @param Invoice $invoice
     * @return array
     */
    private function getData(Invoice $invoice)
    {
        $data = [];

        setlocale(LC_MONETARY,'en_US');

        $data['amount'] =  money_format('$%i', $invoice->getAmount());

        $data['invoice'] = [
            'id' => $invoice->getId(),
            'createdAt' => $invoice->getCreatedAt()->format('m/d/Y')
        ];

        $amc = $invoice->getAmc();

        $data['amc'] = [
            'name' => $amc->getDisplayName(),
            'address' => $amc->getAddress1().', '.$amc->getCity().', '.$amc->getState()->getCode().' '.$amc->getZip(),
            'phone' => $amc->getPhone(),
            'fax' => $amc->getFax(),
            'email' => $amc->getEmail(),
        ];

        $data['items'] = array_map(function(Item $item){
            return [
                'file' => $item->getFileNumber(),
                'jobType' => $item->getJobType(),
                'loan' => $item->getLoanNumber() ?? 'N/A',
                'borrower' => $item->getBorrowerName() ?? 'N/A',
                'address' => $item->getAddress(),
                'orderedAt' => $item->getOrderedAt()->format('m/d/Y'),
                'completedAt' => $item->getOrderedAt()->format('m/d/Y'),
                'amount' => money_format('$%i', $item->getAmount())
            ];
        }, iterator_to_array($invoice->getItems()));

        return $data;
    }
}