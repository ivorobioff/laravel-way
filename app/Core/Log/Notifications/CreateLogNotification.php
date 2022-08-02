<?php
namespace RealEstate\Core\Log\Notifications;

use RealEstate\Core\Log\Entities\Log;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateLogNotification
{
	/**
	 * @var Log
	 */
	private $log;

	/**
	 * @param Log $log
	 */
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	/**
	 * @return Log
	 */
	public function getLog()
	{
		return $this->log;
	}
}