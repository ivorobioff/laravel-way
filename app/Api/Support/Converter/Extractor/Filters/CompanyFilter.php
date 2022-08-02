<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;

use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Api\Support\Converter\Extractor\Filters\AbstractFilter;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Support\Shortcut;

class CompanyFilter extends AbstractFilter
{
    /**
     * @param string $key
     * @param Company $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        if (in_array($key, ['id', 'name'])) {
            return true;
        }

        if (mb_stripos($this->getRoute(), Shortcut::prependGlobalRoutePrefix('v2.0/companies/tax-id')) !== false) {
            return false;
        }

        return true;
    }
}
