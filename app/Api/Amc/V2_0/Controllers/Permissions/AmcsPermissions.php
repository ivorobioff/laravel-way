<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Amc\V2_0\Protectors\CustomerProtector;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AmcsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'admin',
            'store' => 'all',
            'show' => ['owner', 'admin', CustomerProtector::class],
            'update' => ['owner', 'admin']
        ];
    }
}