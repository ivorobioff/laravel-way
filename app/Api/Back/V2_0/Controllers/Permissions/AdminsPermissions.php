<?php
namespace RealEstate\Api\Back\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'admin',
            'show' => 'owner',
            'update' => 'owner'
        ];
    }
}