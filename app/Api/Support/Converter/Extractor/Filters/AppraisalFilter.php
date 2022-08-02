<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Core\Appraisal\Entities\Document as Appraisal;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraisalFilter extends AbstractFilter
{
    use ShowDocumentsToAppraiserTrait;

    /**
     * @param string $key
     * @param Appraisal $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        return $this->canShowDocumentsToAppraiser($object, $this->session, $this->environment)
            || in_array($key, ['showToAppraiser', 'extra', 'id']);
    }
}