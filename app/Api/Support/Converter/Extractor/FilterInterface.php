<?php
namespace RealEstate\Api\Support\Converter\Extractor;
use Restate\Libraries\Converter\Extractor\Root;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface FilterInterface
{
    /**
     * @param string $key
     * @param object $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null);
}