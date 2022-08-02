<?php
namespace RealEstate\Core\Customer\Services;

use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Persistables\AdditionalStatusPersistable;
use RealEstate\Core\Customer\Validation\AdditionalStatusValidator;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusService extends AbstractService
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @param CustomerService $customerService
	 */
	public function initialize(CustomerService $customerService)
	{
		$this->customerService = $customerService;
	}

	/**
	 * @param int $customerId
	 * @return AdditionalStatus[]
	 */
	public function getAllActive($customerId)
	{
		return $this->entityManager
			->getRepository(AdditionalStatus::class)
			->findBy(['customer' => $customerId, 'isActive' => true]);
	}

	/**
	 * @param $customerId
	 * @param AdditionalStatusPersistable $persistable
	 * @return AdditionalStatus
	 */
	public function create($customerId, AdditionalStatusPersistable $persistable)
	{
		/**
		 * @var Customer $customer
		 */
		$customer = $this->entityManager->getReference(Customer::class, $customerId);

		(new AdditionalStatusValidator($this->customerService, $customer))->validate($persistable);

		$additionalStatus = new AdditionalStatus();

		$additionalStatus->setCustomer($customer);

		$this->transfer($persistable, $additionalStatus);

		$this->entityManager->persist($additionalStatus);
		$this->entityManager->flush();

		return $additionalStatus;
	}

	/**
	 * @param int $id
	 * @param AdditionalStatusPersistable $persistable
	 * @param UpdateOptions $options
	 */
	public function update($id, AdditionalStatusPersistable $persistable, UpdateOptions $options = null)
	{
		if ($options == null){
			$options = new UpdateOptions();
		}

		/**
		 * @var AdditionalStatus $additionalStatus
		 */
		$additionalStatus = $this->entityManager->find(AdditionalStatus::class, $id);

		(new AdditionalStatusValidator($this->customerService, $additionalStatus->getCustomer(), $additionalStatus))
			->setForcedProperties($options->getPropertiesScheduledToClear())
			->validate($persistable, true);

		$this->transfer($persistable, $additionalStatus, ['nullable' => $options->getPropertiesScheduledToClear()]);

		$this->entityManager->flush();
	}

	/**
	 * @param int $id
	 */
	public function delete($id)
	{
		/**
		 * @var AdditionalStatus $additionalStatus
		 */
		$additionalStatus = $this->entityManager->getReference(AdditionalStatus::class, $id);

		$isAdditionalStatusUsed = $this->entityManager
			->getRepository(Order::class)
			->exists(['additionalStatus' => $id]);

		if ($isAdditionalStatusUsed){
			$additionalStatus->setActive(false);
		} else {
			$this->entityManager->remove($additionalStatus);
		}

		$this->entityManager->flush();
	}
}