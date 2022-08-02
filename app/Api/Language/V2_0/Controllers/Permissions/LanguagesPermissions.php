<?php
namespace RealEstate\Api\Language\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LanguagesPermissions extends AbstractActionsPermissions
{

    /**
     *
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'all'
        ];
    }
}