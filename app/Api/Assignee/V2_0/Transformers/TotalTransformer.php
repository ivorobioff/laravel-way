<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Assignee\Objects\Total;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class TotalTransformer extends BaseTransformer
{
    /**
     * @param Total $total
     * @return array
     */
    public function transform($total)
    {
        return $this->extract($total);
    }
}
