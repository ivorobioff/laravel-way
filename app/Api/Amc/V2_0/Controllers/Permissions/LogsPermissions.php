<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LogsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'owner',
            'indexByOrder' => 'owner',
            'show' => 'owner'
        ];
    }
}