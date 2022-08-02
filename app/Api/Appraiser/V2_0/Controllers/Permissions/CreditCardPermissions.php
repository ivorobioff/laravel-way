<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Api\Appraiser\V2_0\Protectors\CustomerProtector;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCardPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		return [
			'show' => ['owner', CustomerProtector::class],
			'replace' => 'owner'
		];
	}
}