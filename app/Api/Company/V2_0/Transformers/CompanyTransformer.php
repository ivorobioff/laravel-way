<?php
namespace RealEstate\Api\Company\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Company\Entities\Company;

class CompanyTransformer extends BaseTransformer
{
    /**
     * @param Company $company
     * @return array
     */
    public function transform($company)
    {
        return $this->extract($company);
    }
}
