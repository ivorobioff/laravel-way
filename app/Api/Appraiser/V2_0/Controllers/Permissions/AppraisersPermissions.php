<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraisersPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'all',
            'show' => 'auth',
			'index' => 'auth',
            'update' => ['owner', 'admin'],
			'changePrimaryLicense' => 'owner',
			'updateAvailability' => 'owner'
        ];
    }
}