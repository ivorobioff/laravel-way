<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Api\Appraisal\V2_0\Support\MessageReaderResolver;
use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Api\Support\Searchable\SortableTrait;
use RealEstate\Core\Appraisal\Services\ResponderService;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagesSearchableProcessor extends BaseSearchableProcessor
{
	use SortableTrait;

	protected function configuration()
	{
		return [
			'filter' => [
				'isRead' => function($value){
					if (!in_array($value, ['true', 'false', true, false], true)){
						return null;
					}

					$constraint = new Constraint(Constraint::CONTAIN);

					if (in_array($value, [false, 'false'], true)){
						$constraint->setNot(true);
					}

                    /**
                     * @var MessageReaderResolver $readerResolver
                     */
					$readerResolver = $this->container->make(MessageReaderResolver::class);

					return new Criteria('readers', $constraint, $readerResolver->getReader());
				},
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

		return $responderService->canResolveMessageSortable($sortable);
	}
}