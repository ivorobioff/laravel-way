<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Api\Support\Converter\Extractor\FilterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class NullFilter implements FilterInterface
{
    /**
     * @param string $key
     * @param object $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        return true;
    }
}