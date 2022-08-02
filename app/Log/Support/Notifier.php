<?php
namespace RealEstate\Log\Support;

use RealEstate\Core\Log\Services\LogService;
use RealEstate\Core\Session\Services\SessionService;
use RealEstate\Core\Shared\Interfaces\NotifierInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Notifier implements NotifierInterface
{
	/**
	 * @var LogService
	 */
	private $logService;

	/**
	 * @var SessionService
	 */
	private $sessionService;

	/**
	 * @param LogService $logService
	 * @param SessionService $sessionService
	 */
	public function __construct(LogService $logService, SessionService $sessionService)
	{
		$this->logService = $logService;
		$this->sessionService = $sessionService;
	}

	/**
	 * @param object $notification
	 */
	public function notify($notification)
	{
		if (!$this->logService->canCreate($notification)){
			return ;
		}

		$this->logService->create($notification);
	}
}