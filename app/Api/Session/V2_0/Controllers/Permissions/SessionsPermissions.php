<?php
namespace RealEstate\Api\Session\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Session\V2_0\Protectors\AutoLoginProtector;
use RealEstate\Api\Session\V2_0\Protectors\SessionProtector;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionsPermissions extends AbstractActionsPermissions
{

    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'all',
            'show' => SessionProtector::class,
            'destroy' => SessionProtector::class,
            'destroyAll' => SessionProtector::class,
			'storeAutoLoginToken' => AutoLoginProtector::class,
            'refresh' => SessionProtector::class
        ];
    }
}