<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Log\Services\ResponderService;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LogsSearchableProcessor extends BaseSearchableProcessor
{
	use SortableTrait;

	protected function configuration()
	{
		return [
			'filter' => [
				'initiator' => function($value){
					if (!in_array($value, ['false', false], true)){
						return null;
					}

					/**
					 * @var Session $session
					 */
					$session = $this->container->make(Session::class);

					return new Criteria('initiator', new Constraint(Constraint::EQUAL, true), $session->getUser());
				}
			]
		];
	}

	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	protected function isResolvable(Sortable $sortable)
	{
		/**
		 * @var ResponderService $responderService
		 */
		$responderService = $this->container->make(ResponderService::class);

		return  $responderService->canResolveSortable($sortable);
	}
}