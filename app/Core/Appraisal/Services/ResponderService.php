<?php
namespace RealEstate\Core\Appraisal\Services;

use RealEstate\Core\Appraisal\Criteria\AdditionalDocumentSorterResolver;
use RealEstate\Core\Appraisal\Criteria\DocumentSorterResolver;
use RealEstate\Core\Appraisal\Criteria\MessageSorterResolver;
use RealEstate\Core\Appraisal\Criteria\SorterResolver;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * The "Responder" pattern is intended to be used by other layers in order to avoid
 * exposing internal logic of the core layer by allowing the other layers ask the core layer to provide
 * some useful information.
 *
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ResponderService
{
	/**
	 * Since we don't want to expose the SorterResolver outside the core layer we provide this method to allow
	 * the other layers to ask the core layer whether it can sort the result by the provided sortable object.
	 *
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolveSortable(Sortable $sortable)
	{
		return (new SorterResolver())->canResolve($sortable);
	}

	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolveMessageSortable(Sortable $sortable)
	{
		return (new MessageSorterResolver())->canResolve($sortable);
	}

	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolveAdditionalDocumentSortable(Sortable $sortable)
	{
		return (new AdditionalDocumentSorterResolver())->canResolve($sortable);
	}

	/**
	 * @param Sortable $sortable
	 * @return bool
	 */
	public function canResolverDocumentSortable(Sortable $sortable)
	{
		return (new DocumentSorterResolver())->canResolve($sortable);
	}
}