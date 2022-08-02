<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
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
            'totals' => 'owner',
            'changeAdditionalStatus' => 'owner',
            'listAdditionalStatuses' => 'owner',
            'destroy' => 'owner',
        ];
    }
}