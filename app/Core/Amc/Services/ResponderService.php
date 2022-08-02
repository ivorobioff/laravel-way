<?php
namespace RealEstate\Core\Amc\Services;
use RealEstate\Core\Amc\Criteria\InvoiceSorterResolver;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ResponderService
{
    /**
     * @param Sortable $sortable
     * @return bool
     */
    public function canResolveInvoiceSortable(Sortable $sortable)
    {
        return (new InvoiceSorterResolver())->canResolve($sortable);
    }
}