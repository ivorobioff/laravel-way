<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Assignee\Entities\CustomerFee;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerFeeTransformer extends BaseTransformer
{
    /**
     * @param CustomerFee $fee
     * @return array
     */
    public function transform($fee)
    {
        return $this->extract($fee);
    }
}
