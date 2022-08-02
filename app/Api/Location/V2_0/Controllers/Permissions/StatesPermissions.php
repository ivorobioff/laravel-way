<?php
namespace RealEstate\Api\Location\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StatesPermissions extends AbstractActionsPermissions
{

    /**
     *
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'all',
            'zips' => 'all'
        ];
    }
}