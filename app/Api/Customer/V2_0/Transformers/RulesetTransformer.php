<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;
use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\Ruleset;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesetTransformer extends BaseTransformer
{
    /**
     * @param Ruleset $item
     * @return array
     */
    public function transform($item)
    {
        return $this->extract($item);
    }
}