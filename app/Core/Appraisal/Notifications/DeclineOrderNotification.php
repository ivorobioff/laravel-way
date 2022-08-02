<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Enums\DeclineReason;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeclineOrderNotification extends AbstractNotification
{
	/**
	 * @var DeclineReason
	 */
	private $reason;

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @param Order $order
	 * @param DeclineReason $reason
	 * @param string $message
	 */
	public function __construct(Order $order, DeclineReason $reason, $message = null)
	{
		parent::__construct($order);
		$this->reason = $reason;
		$this->message = $message;
	}

	/**
	 * @return DeclineReason
	 */
	public function getReason()
	{
		return $this->reason;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}
}