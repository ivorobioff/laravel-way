<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Appraisal\Enums\Due;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersSearchableProcessor extends BaseSearchableProcessor
{
	use SortableTrait;

	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'search' => [
				'clientName' => Constraint::SIMILAR,
				'customer.name' => Constraint::SIMILAR,
				'borrowerName' => Constraint::SIMILAR,
				'property.city' => Constraint::SIMILAR,
				'property.address' => Constraint::SIMILAR,
				'fileNumber' => Constraint::SIMILAR,
				'loanNumber' => Constraint::SIMILAR,
				'property.zip' => Constraint::SIMILAR,
			],
			'filter' => [
				'processStatus' => [
					'constraint' => Constraint::IN,
					'type' => [['enum', ProcessStatus::class]]
				],
				'fileNumber' => Constraint::EQUAL,
				'property.state' => Constraint::EQUAL,
				'property.zip' => Constraint::EQUAL,
				'orderedAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'orderedAt.day' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'orderedAt.from' => [
					'constraint' => Constraint::GREATER_OR_EQUAL,
					'type' => 'day'
				],
				'orderedAt.to' => [
					'constraint' => Constraint::LESS_OR_EQUAL,
					'type' => 'day'
				],
				'orderedAt.year' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'orderedAt.month' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'dueDate' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'due' => [
					'constraint' => Constraint::EQUAL,
					'type' => ['enum', Due::class]
				],
				'acceptedAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'inspectionCompletedAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'inspectionScheduledAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'estimatedCompletionDate' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'putOnHoldAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'completedAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'completedAt.day' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'completedAt.from' => [
					'constraint' => Constraint::GREATER_OR_EQUAL,
					'type' => 'day'
				],
				'completedAt.to' => [
					'constraint' => Constraint::LESS_OR_EQUAL,
					'type' => 'day'
				],
				'completedAt.year' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'completedAt.month' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'paidAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'paidAt.day' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'paidAt.from' => [
					'constraint' => Constraint::GREATER_OR_EQUAL,
					'type' => 'day'
				],
				'paidAt.to' => [
					'constraint' => Constraint::LESS_OR_EQUAL,
					'type' => 'day'
				],
				'paidAt.year' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'paidAt.month' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'int'
				],
				'revisionReceivedAt' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'day'
				],
				'isPaid' => [
					'constraint' => Constraint::EQUAL,
					'type' => 'bool'
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

		return  $responderService->canResolveSortable($sortable);
	}
}