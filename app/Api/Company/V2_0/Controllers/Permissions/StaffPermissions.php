<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\CompanyAdminProtector;
use RealEstate\Api\Company\V2_0\Protectors\CompanyManagerProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => [CompanyAdminProtector::class, CompanyManagerProtector::class],
            'indexByBranch' => [CompanyAdminProtector::class, CompanyManagerProtector::class],
            'storeManager' => CompanyAdminProtector::class,
            'show' => [CompanyAdminProtector::class],
            'destroy' => [CompanyAdminProtector::class],
            'update' => [CompanyAdminProtector::class]
        ];
    }
}