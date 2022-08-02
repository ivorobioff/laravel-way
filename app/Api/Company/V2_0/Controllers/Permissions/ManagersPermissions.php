<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Company\V2_0\Protectors\AdminForManagerProtector;

class ManagersPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'update' => ['owner', AdminForManagerProtector::class],
            'show' => ['owner', AdminForManagerProtector::class]
        ];
    }
}
