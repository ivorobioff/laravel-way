<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;
use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
       return [
           'index' => 'owner',
           'show' => 'owner',
           'store' => 'owner',
           'update' => 'owner',
           'destroy' => 'owner'
       ];
    }
}