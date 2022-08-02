<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;
use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Appraisal\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsSearchableProcessor extends BaseSearchableProcessor
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

        return $responderService->canResolverDocumentSortable($sortable);
    }
}