<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesetsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'show' => 'owner',
            'store' => 'owner',
            'destroy' => 'owner',
            'update' => 'owner'
        ];
    }
}