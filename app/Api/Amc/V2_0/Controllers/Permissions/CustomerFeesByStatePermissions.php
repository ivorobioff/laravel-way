<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Amc\V2_0\Protectors\CustomerProtector;

class CustomerFeesByStatePermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => ['owner', CustomerProtector::class],
            'sync' => 'owner',
            'update' => 'owner',
        ];
    }
}
