<?php
namespace RealEstate\Core\Appraiser\Services;

use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Assignee\Services\CustomerFeeService as AbstractCustomerFeeService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerFeeService extends AbstractCustomerFeeService
{
	protected function getAssigneeClass()
	{
		return Appraiser::class;
	}

	protected function getAssigneeServiceClass()
	{
		return AppraiserService::class;
	}
}