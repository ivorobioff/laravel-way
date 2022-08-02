<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Customer\V2_0\Protectors\AppraiserProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomersPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'store' => 'all',
			'show' => ['owner', AppraiserProtector::class],
			'update' => 'owner'
		];
	}
}