<?php
namespace RealEstate\Core\Document\Support;

use RealEstate\Core\Document\Entities\Document;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait DocumentUsageManagementTrait
{
    /**
     * @param Document|null $oldDocument
     * @param Document|null $newDocument
     */
    protected function handleUsageOfOneDocument($oldDocument, $newDocument)
    {
        (new DocumentUsageManagement())->handleSingle($oldDocument, $newDocument);
    }

    /**
     *
     * @param Document[]|null $oldDocuments
     * @param Document[]|Document $newDocuments
     */
    protected function handleUsageOfMultipleDocuments($oldDocuments, $newDocuments)
    {
        (new DocumentUsageManagement())->handleMultiple($oldDocuments, $newDocuments);
    }
}