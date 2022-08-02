<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\AppraiserProtector;
use RealEstate\Api\Company\V2_0\Protectors\CompanyAdminProtector;

class CompaniesPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => AppraiserProtector::class,
            'update' => CompanyAdminProtector::class,
            'showByTaxId' => 'auth',
        ];
    }
}
