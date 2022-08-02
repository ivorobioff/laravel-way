<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentsPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'index' => 'owner',
			'show' => 'owner',
			'store' => 'owner',
			'destroy' => 'owner',
			'update' => 'owner'
		];
	}
}