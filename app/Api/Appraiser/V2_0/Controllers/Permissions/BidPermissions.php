<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Assignee\V2_0\Protectors\CustomerByOrderProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'store' => 'owner',
			'show' => ['owner', CustomerByOrderProtector::class]
		];
	}
}