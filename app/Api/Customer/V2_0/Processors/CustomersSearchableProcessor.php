<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Customer\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomersSearchableProcessor extends BaseSearchableProcessor
{
    use SortableTrait;

    /**
     * @param Sortable $sortable
     * @return bool
     */
    protected function isResolvable(Sortable $sortable)
    {
        /**
         * @var ResponderService $responderService
         */
        $responderService = $this->container->make(ResponderService::class);

        return $responderService->canResolveSortable($sortable);
    }
}
