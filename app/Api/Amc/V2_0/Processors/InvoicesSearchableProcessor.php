<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Amc\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoicesSearchableProcessor extends BaseSearchableProcessor
{
    use SortableTrait;

    protected function configuration()
    {
        return [
            'filter' => [
                'isPaid' => [
                    'constraint' => Constraint::EQUAL,
                    'type' => 'bool'
                ]
            ]
        ];
    }

    /**
     * @param Sortable $sortable
     * @return bool
     */
    protected function isResolvable(Sortable $sortable)
    {
        /**
         * @var ResponderService $responder
         */
        $responder = $this->container->make(ResponderService::class);

        return $responder->canResolveInvoiceSortable($sortable);
    }
}