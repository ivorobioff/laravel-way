<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagesPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'store' => 'owner',
			'show' => 'owner',
			'index' => 'owner',
			'indexByOrder' => 'owner',
			'markAsRead' => 'owner',
			'markAllAsRead' => 'owner',
			'markSomeAsRead' => 'owner',
			'destroy' => 'owner',
			'destroyAll' => 'owner'
		];
	}
}