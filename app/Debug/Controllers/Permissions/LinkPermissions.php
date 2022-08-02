<?php
namespace RealEstate\Debug\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LinkPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'store' => 'all'
		];
	}
}