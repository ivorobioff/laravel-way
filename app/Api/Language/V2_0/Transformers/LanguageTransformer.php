<?php
namespace RealEstate\Api\Language\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Language\Entities\Language;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LanguageTransformer extends BaseTransformer
{

    /**
     *
     * @param Language $language
     * @return array
     */
    public function transform($language)
    {
        return $this->extract($language);
    }
}