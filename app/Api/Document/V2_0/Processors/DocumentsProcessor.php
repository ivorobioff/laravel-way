<?php
namespace RealEstate\Api\Document\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use RealEstate\Api\Support\Converter\Populator\DocumentPersistableResolver;
use RealEstate\Api\Support\Validation\Rules\Document;
use RealEstate\Core\Document\Persistables\DocumentPersistable;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsProcessor extends AbstractProcessor
{
    /**
     * @param Binder $binder
     */
    protected function rules(Binder $binder)
    {
        $binder->bind('document', function (Property $property) {
            $property->addRule(new Document());
        });
    }

    /**
     *
     * @return DocumentPersistable
     */
    public function createPersistable()
    {
        $file = $this->get('document');

        $persistable = new DocumentPersistable();

        if ($file) {
            DocumentPersistableResolver::populate($persistable, $file);
        }

        return $persistable;
    }
}