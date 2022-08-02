<?php
namespace RealEstate\Core\Appraisal\Services;

use RealEstate\Core\Appraisal\Entities\Message;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;
use RealEstate\Core\Appraisal\Options\CreateMessageOptions;
use RealEstate\Core\Appraisal\Persistables\MessagePersistable;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Support\Service\AbstractService;
use DateTime;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractMessageFactoryService extends AbstractService
{
	/**
	 * @param User $sender
	 * @param Order $order
	 * @param MessagePersistable $persistable
	 * @param Message $message
	 */
	protected function exchange(User $sender, Order $order, MessagePersistable $persistable, Message $message)
	{
		$message->setContent($persistable->getContent());

		if ($createdAt = $this->environment->getLogCreatedAt()){
			$message->setCreatedAt($createdAt);
		} else {
			$message->setCreatedAt(new DateTime());
		}

		$message->setOrder($order);
		$message->setSender($sender);
	}


	/**
	 * @param int $senderId
	 * @param int $orderId
	 * @param MessagePersistable $persistable
	 * @param CreateMessageOptions $options
	 * @return Message
	 */
	public function create($senderId, $orderId, MessagePersistable $persistable, CreateMessageOptions $options = null)
	{
		if ($options === null){
			$options = new CreateMessageOptions();
		}

		if (!$options->isTrusted()){
			$this->validate($senderId, $orderId, $persistable);
		}

		$message = $this->instantiate($senderId, $orderId, $persistable);

		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->getReference(Order::class, $orderId);

		/**
		 * @var User $sender
		 */
		$sender = $this->entityManager->getReference(User::class, $senderId);

		$this->exchange($sender, $order, $persistable, $message);

		$this->entityManager->persist($message);

		$this->entityManager->flush();

		$message->addReader($sender);

		if ($this->environment->isRelaxed() && !$sender instanceof Appraiser){
			$message->addReader($order->getAssignee());
		}

		$this->entityManager->flush();

		$this->notify(new SendMessageNotification($order, $message));

		return $message;
	}

	/**
	 * @param $senderId
	 * @param $orderId
	 * @param MessagePersistable $persistable
	 */
	abstract protected function validate($senderId, $orderId, MessagePersistable $persistable);

	/**
	 * @param int $senderId
	 * @param int $orderId
	 * @param MessagePersistable $persistable
	 * @return Message
	 */
	abstract protected function instantiate($senderId, $orderId, MessagePersistable $persistable);
}