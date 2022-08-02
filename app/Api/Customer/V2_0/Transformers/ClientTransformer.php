<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;
use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\Client;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientTransformer extends BaseTransformer
{
    /**
     * @param Client $item
     * @return array
     */
    public function transform($item)
    {
        return $this->extract($item);
    }
}