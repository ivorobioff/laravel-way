<?php
namespace RealEstate\Core\Customer\Services;

use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Services\AbstractMessageFactoryService;
use RealEstate\Core\Customer\Entities\Message;
use RealEstate\Core\Appraisal\Entities\Message as BaseMessage;
use RealEstate\Core\Customer\Persistables\MessagePersistable;
use RealEstate\Core\Appraisal\Persistables\MessagePersistable as BaseMessagePersistable;
use RealEstate\Core\Customer\Validation\MessageValidator;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageFactoryService extends AbstractMessageFactoryService
{
	/**
	 * @param $senderId
	 * @param $orderId
	 * @param MessagePersistable|BaseMessagePersistable $persistable
	 * @return Message
	 */
	protected function validate($senderId, $orderId, BaseMessagePersistable $persistable)
	{
		(new MessageValidator())->validate($persistable);
	}

	/**
	 * @param int $senderId
	 * @param int $orderId
	 * @param BaseMessagePersistable $persistable
	 * @return BaseMessage
	 */
	protected function instantiate($senderId, $orderId, BaseMessagePersistable $persistable)
	{
		return new Message();
	}

	/**
	 * @param User $sender
	 * @param Order $order
	 * @param BaseMessagePersistable|MessagePersistable $persistable
	 * @param BaseMessage|Message $message
	 */
	protected function exchange(User $sender, Order $order, BaseMessagePersistable $persistable, BaseMessage $message)
	{
		parent::exchange($sender, $order, $persistable, $message);

		$message->setEmployee($persistable->getEmployee());
	}
}