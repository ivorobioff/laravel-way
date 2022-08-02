<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Core\Appraisal\Entities\Document as Appraisal;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentFilter extends AbstractFilter
{
    use ShowDocumentsToAppraiserTrait;

    /**
     * @param string $key
     * @param object $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        if ($root !== null  && $root->getObject() instanceof Appraisal && $root->getKey() === 'extra'){

            /**
             * @var Appraisal $appraisal
             */
            $appraisal = $root->getObject();

            return $this->canShowDocumentsToAppraiser($appraisal, $this->session, $this->environment)
            || in_array($key, ['format', 'id']);
        }

        return true;
    }
}