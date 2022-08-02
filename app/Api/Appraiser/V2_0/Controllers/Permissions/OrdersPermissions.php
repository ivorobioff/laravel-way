<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Assignee\V2_0\Protectors\CustomerByOrderProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'index' => 'owner',
			'show' => ['owner', CustomerByOrderProtector::class],
			'accept' => 'owner',
			'acceptWithConditions' => 'owner',
			'decline' => 'owner',
			'totals' => 'owner',
			'pay' => 'owner',
			'listAdditionalStatuses' => ['owner', CustomerByOrderProtector::class],
			'changeAdditionalStatus' => 'owner',
			'reassign' => 'owner'
		];
	}
}