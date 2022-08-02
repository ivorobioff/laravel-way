<?php
namespace RealEstate\Api\Location\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Location\Entities\State;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StateTransformer extends BaseTransformer
{

    /**
     *
     * @param State $state
     * @return array
     */
    public function transform($state)
    {
        return $this->extract($state);
    }
}