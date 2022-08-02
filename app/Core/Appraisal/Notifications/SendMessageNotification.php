<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\Message;
use RealEstate\Core\Appraisal\Entities\Order;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SendMessageNotification extends AbstractNotification
{
	/**
	 * @var Message
	 */
	private $message;

	public function __construct(Order $order, Message $message)
	{
		parent::__construct($order);

		$this->message = $message;
	}

	/**
	 * @return Message
	 */
	public function getMessage()
	{
		return $this->message;
	}
}