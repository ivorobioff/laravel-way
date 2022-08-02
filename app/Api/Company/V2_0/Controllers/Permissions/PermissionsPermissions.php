<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\CompanyAdminProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PermissionsPermissions extends AbstractActionsPermissions
{

    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => [CompanyAdminProtector::class],
            'replace' => [CompanyAdminProtector::class]
        ];
    }
}