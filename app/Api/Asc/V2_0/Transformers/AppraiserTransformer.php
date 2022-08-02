<?php
namespace RealEstate\Api\Asc\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Asc\Entities\AscAppraiser;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserTransformer extends BaseTransformer
{

    /**
     * @param AscAppraiser $appraiser
     * @return array
     */
    public function transform($appraiser)
    {
        return $this->extract($appraiser);
    }
}