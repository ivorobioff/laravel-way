<?php
namespace RealEstate\Console\Cron;

use RealEstate\Core\Session\Services\SessionService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DestroyExpiredSessionsCommand extends AbstractCommand
{
	/**
	 * @param SessionService $sessionService
	 */
	public function fire(SessionService $sessionService)
	{
		$sessionService->deleteAllExpired();
	}
}