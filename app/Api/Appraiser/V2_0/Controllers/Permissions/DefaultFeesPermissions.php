<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DefaultFeesPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'index' => 'owner',
			'store' => 'owner',
			'update' => 'owner',
			'updateBulk' => 'owner',
			'destroy' => 'owner',
			'destroyBulk' => 'owner',
		];
	}
}