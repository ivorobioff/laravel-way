<?php
namespace RealEstate\Api\Company\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'owner',
            'show' => 'owner',
            'accept' => 'owner',
            'acceptWithConditions' => 'owner',
            'decline' => 'owner',
            'listAdditionalStatuses' => 'owner',
            'changeAdditionalStatus' => 'owner',
            'reassign' => 'owner',
        ];
    }
}