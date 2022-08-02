<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\CompanyManagerProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeesPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => CompanyManagerProtector::class,
            'replace' => CompanyManagerProtector::class
        ];
    }
}