<?php
namespace RealEstate\Api\Asc\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 *
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
            'index' => 'all'
        ];
    }
}