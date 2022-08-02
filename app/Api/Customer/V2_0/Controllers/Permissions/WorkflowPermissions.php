<?php
namespace RealEstate\Api\Customer\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class WorkflowPermissions extends AbstractActionsPermissions
{
	/**
	 * @return array
	 */
	protected function permissions()
	{
		$values = ProcessStatus::toArray();

		$actions = [];

		foreach ($values as $value){

			$actions[camel_case($value === 'new' ? 'fresh' : $value)] = 'owner';
		}

		return $actions;
	}
}