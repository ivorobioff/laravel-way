<?php
namespace RealEstate\Console\Cron;

use RealEstate\Core\Document\Services\DocumentService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DestroyUnusedDocumentsCommand extends AbstractCommand
{
	/**
	 * @param DocumentService $documentService
	 */
	public function fire(DocumentService $documentService)
	{
		$documentService->deleteAllUnused();
	}
}