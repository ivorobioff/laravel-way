<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\CompanyAdminProtector;
use RealEstate\Api\Company\V2_0\Protectors\CompanyManagerProtector;

class InvitationsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => [CompanyAdminProtector::class, CompanyManagerProtector::class],
            'store' => [CompanyAdminProtector::class, CompanyManagerProtector::class]
        ];
    }
}
