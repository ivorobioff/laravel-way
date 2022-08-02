<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Customer\V2_0\Protectors\AppraiserProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'show' => ['owner', AppraiserProtector::class],
			'update' => 'owner'
		];
	}
}