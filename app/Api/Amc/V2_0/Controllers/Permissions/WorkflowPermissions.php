<?php
namespace RealEstate\Api\Amc\V2_0\Controllers\Permissions;

use Restate\Libraries\Permissions\AbstractActionsPermissions;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;

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

        $actions['resume'] = 'owner';

        return $actions;
    }
}
