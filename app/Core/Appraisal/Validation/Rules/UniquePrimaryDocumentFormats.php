<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;

use RealEstate\Core\Document\Persistables\Identifiers;
use RealEstate\Core\Document\Services\DocumentService as SourceService;


/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UniquePrimaryDocumentFormats extends AbstractRule
{
    /**
     * @var SourceService
     */
    private $sourceService;

    /**
     * @param SourceService $sourceService
     */
    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;

        $this
            ->setMessage('The documents must have different formats.')
            ->setIdentifier('unique');
    }

    /**
     * @param mixed|Value|Identifiers $value
     * @return Error|null
     */
    public function check($value)
    {
        $documents = $this->sourceService->getAllSelected($value->getIds());

        $formats = [];

        foreach ($documents as $document){
            if (in_array((string) $document->getFormat(), $formats)){
                return $this->getError();
            }

            $formats[] = (string) $document->getFormat();
        }

        return null;
    }
}