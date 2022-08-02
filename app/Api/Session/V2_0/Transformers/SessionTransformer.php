<?php
namespace RealEstate\Api\Session\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionTransformer extends BaseTransformer
{
    /**
     * @param Session $session
     * @return array
     */
    public function transform($session)
    {
        return $this->extract($session);
    }
} 