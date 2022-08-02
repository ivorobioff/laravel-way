<?php
namespace RealEstate\Api\Support;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DefaultTransformer extends BaseTransformer
{
    /**
     * @param object $item
     * @return array
     */
    public function transform($item)
    {
        return $this->extract($item);
    }
}