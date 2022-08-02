<?php
namespace RealEstate\Core\Document\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Document\Persistables\Identifier;
use RealEstate\Core\Document\Persistables\Identifiers;
use RealEstate\Core\Document\Services\DocumentService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentExists extends AbstractRule
{

    /**
     *
     * @var DocumentService
     */
    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;

        $this->setIdentifier('exists');
        $this->setMessage('The document with the provided ID does not exist.');
    }

    /**
     *
     * @param Identifier|Identifiers $value
     * @return Error|null
     */
    public function check($value)
    {
        $ids = $value instanceof Identifiers ? $value->getIds() : $value->getId();

        if (! $this->documentService->exists($ids)) {
            return $this->getError();
        }

        return null;
    }
}