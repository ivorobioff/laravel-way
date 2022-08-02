<?php
namespace RealEstate\Api\Help\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class HelpPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'storeIssues' => 'auth',
			'storeFeatureRequests' => 'auth',
			'hints' => 'all'
		];
	}
}