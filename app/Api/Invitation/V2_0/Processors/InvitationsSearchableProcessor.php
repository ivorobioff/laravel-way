<?php
namespace RealEstate\Api\Invitation\V2_0\Processors;

use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\Core\Invitation\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationsSearchableProcessor extends BaseSearchableProcessor
{
	use SortableTrait;

	protected function configuration()
	{
		return [
			'filter' => [
				'status' => [
					'constraint' => Constraint::IN,
					'type' => [['enum', Status::class]]
				]
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

		return $responderService->canResolveSortable($sortable);
	}
}