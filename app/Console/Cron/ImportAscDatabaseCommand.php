<?php
namespace RealEstate\Console\Cron;

use RealEstate\Core\Asc\Services\AscService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ImportAscDatabaseCommand extends AbstractCommand
{
	/**
	 * @param AscService $ascService
	 */
	public function fire(AscService $ascService)
	{
		$ascService->import();
	}
}