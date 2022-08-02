<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\InvoicesSearchableProcessor;
use RealEstate\Api\Amc\V2_0\Processors\PayInvoiceProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Amc\Options\FetchInvoicesOptions;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Amc\Services\InvoiceService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoicesController extends BaseController
{
    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @param InvoiceService $invoiceService
     */
    public function initialize(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @param int $amcId
     * @param InvoicesSearchableProcessor $processor
     * @return Response
     */
    public function index($amcId, InvoicesSearchableProcessor $processor)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($amcId, $processor){

                $options = new FetchInvoicesOptions();
                $options->setCriteria($processor->getCriteria());
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setSortables($processor->createSortables());

                return $this->invoiceService->getAll($amcId, $options);
            },
            'getTotal' => function() use ($amcId, $processor){
                return $this->invoiceService->getTotal($amcId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll($this->paginator($adapter), $this->transformer());
    }

    /**
     * @param int $amcId
     * @param int $invoiceId
     * @param PayInvoiceProcessor  $processor
     * @return Response
     */
    public function pay($amcId, $invoiceId, PayInvoiceProcessor $processor)
    {
        $this->invoiceService->pay($invoiceId, $processor->getMeans());

        return $this->resource->blank();
    }

    /**
     * @param AmcService $amcService
     * @param int $amcId
     * @param int $invoiceId
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $amcId, $invoiceId = null)
    {
        if (!$amcService->exists($amcId)){
            return false;
        }

        if ($invoiceId === null){
            return true;
        }

        return $amcService->hasInvoice($amcId, $invoiceId);
    }
}