<?php
namespace RealEstate\Core\Assignee\Services;

use RealEstate\Core\Assignee\Entities\NotificationSubscription;
use RealEstate\Core\Assignee\Persistables\NotificationSubscriptionPersistable;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class NotificationSubscriptionService extends AbstractService
{
	/**
	 * @param int $assigneeId
	 * @return NotificationSubscription[]
	 */
	public function getAll($assigneeId)
	{
		return $this->entityManager
			->getRepository(NotificationSubscription::class)
			->findBy(['assignee' => $assigneeId]);
	}

	/**
	 * @param int $assigneeId
	 * @param NotificationSubscriptionPersistable[] $persistables
	 */
	public function updateBySelectedCustomers($assigneeId, array $persistables)
	{
		/**
		 * @var NotificationSubscription[] $subscriptions
		 */
		$subscriptions = $this->entityManager
			->getRepository(NotificationSubscription::class)
			->retrieveAll(['assignee' => $assigneeId, 'customer' =>  ['in', array_keys($persistables)]]);

		foreach ($subscriptions as $subscription){
			$customerId = $subscription->getCustomer()->getId();

			if (($email = $persistables[$customerId]->getEmail()) !== null){
				$subscription->setEmail($email);
			}
		}

		$this->entityManager->flush();
	}

	/**
	 * @param int $assigneeId
	 * @param int $customerId
	 * @return NotificationSubscription
	 */
	public function getByCustomerId($assigneeId, $customerId)
	{
		return $this->entityManager->getRepository(NotificationSubscription::class)
			->findOneBy(['customer' => $customerId, 'assignee' => $assigneeId]);
	}

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @return NotificationSubscription
     */
	public function subscribe($assigneeId, $customerId)
    {
        $subscription = new NotificationSubscription();
        $subscription->setAssignee($this->entityManager->getReference(User::class, $assigneeId));
        $subscription->setCustomer($this->entityManager->getReference(Customer::class, $customerId));
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        return $subscription;
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @return NotificationSubscription
     */
    public function subscribeIfNot($assigneeId, $customerId)
    {
        $isSubscribed = $this->entityManager->getRepository(NotificationSubscription::class)
            ->exists(['customer' => $customerId, 'assignee' => $assigneeId]);

        if ($isSubscribed){
            return null;
        }

        return $this->subscribe($assigneeId, $customerId);
    }
}