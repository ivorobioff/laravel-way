<?php
namespace RealEstate\Api\Back\V2_0\Transformers;
use RealEstate\Api\Support\BaseTransformer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminTransformer extends BaseTransformer
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