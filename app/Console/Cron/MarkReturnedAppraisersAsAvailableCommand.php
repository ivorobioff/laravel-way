<?php
namespace RealEstate\Console\Cron;

use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MarkReturnedAppraisersAsAvailableCommand extends AbstractCommand
{
	/**
	 * @param AppraiserService $appraiserService
	 */
	public function fire(AppraiserService $appraiserService)
	{
		$appraiserService->markAllReturnedAsAvailable();
	}
}