<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByStatePermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'owner',
            'sync' => 'owner',
            'update' => 'owner'
        ];
    }
}