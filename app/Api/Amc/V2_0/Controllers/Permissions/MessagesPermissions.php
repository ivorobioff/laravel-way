<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MessagesPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'owner',
            'indexByOrder' => 'owner',
            'index' => 'owner',
            'show' => 'owner',
            'markAsRead' => 'owner',
            'markSomeAsRead' => 'owner',
            'markAllAsRead' => 'owner',
            'total' => 'owner'
        ];
    }
}