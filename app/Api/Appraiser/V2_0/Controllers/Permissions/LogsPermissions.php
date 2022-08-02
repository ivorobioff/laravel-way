<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Assignee\V2_0\Protectors\CustomerByOrderProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LogsPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'index' => 'owner',
			'indexByOrder' => ['owner', CustomerByOrderProtector::class]
		];
	}
}