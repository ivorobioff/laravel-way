<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

class CustomersPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'owner',
            'listAdditionalStatuses' => 'owner',
            'listAdditionalDocumentsTypes' => 'owner',
        ];
    }
}
