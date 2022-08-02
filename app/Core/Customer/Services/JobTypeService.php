<?php
namespace RealEstate\Core\Customer\Services;

use RealEstate\Core\Assignee\Entities\CustomerFee;
use RealEstate\Core\Customer\Criteria\JobTypeFilterResolver;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Customer\Options\FetchJobTypesOptions;
use RealEstate\Core\Customer\Persistables\JobTypePersistable;
use RealEstate\Core\Customer\Validation\JobTypeValidator;
use RealEstate\Core\JobType\Entities\JobType as Local;
use RealEstate\Core\JobType\Services\JobTypeService as LocalService;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeService extends AbstractService
{
	/**
	 * @var LocalService
	 */
	private $localService;

    /**
     * @param LocalService $localService
     */
	public function initialize(LocalService $localService)
	{
		$this->localService = $localService;
	}

	/**
	 * @param int $customerId
     * @param FetchJobTypesOptions $options
	 * @return JobType[]
	 */
	public function getAllVisible($customerId, FetchJobTypesOptions $options = null)
	{
        if ($options === null){
            $options = new FetchJobTypesOptions();
        }

        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->select('j')
            ->from(JobType::class, 'j')
            ->andWhere($builder->expr()->eq('j.customer', ':customer'))->setParameter('customer', $customerId)
            ->andWhere($builder->expr()->eq('j.isHidden', ':isHidden'))->setParameter('isHidden', false);

        (new Filter())->apply($builder, $options->getCriteria(), new JobTypeFilterResolver());

        return $builder->getQuery()->getResult();
	}

	/**
	 * @param int $customerId
	 * @return JobType[]
	 */
	public function getAllPayable($customerId)
	{
		return $this->entityManager
			->getRepository(JobType::class)
			->findBy(['customer' => $customerId, 'isHidden' => false, 'isPayable' => true]);
	}

	/**
	 * @param int $customerId
	 * @param JobTypePersistable $persistable
	 * @return JobType
	 */
	public function create($customerId, JobTypePersistable $persistable)
	{
		/**
		 * @var Customer $customer
		 */
		$customer = $this->entityManager->getReference(Customer::class, $customerId);

		(new JobTypeValidator($customer, $this->container))->validate($persistable);

		$jobType = new JobType();

		$this->exchange($persistable, $jobType);

		$jobType->setCustomer($customer);

		$this->entityManager->persist($jobType);

		$this->entityManager->flush();

		return $jobType;
	}

	/**
	 * @param int $id
	 * @param JobTypePersistable $persistable
	 * @param UpdateOptions $options
	 */
	public function update($id, JobTypePersistable $persistable, UpdateOptions $options = null)
	{
		if ($options === null){
			$options = new UpdateOptions();
		}

		/**
		 * @var JobType $jobType
		 */
		$jobType = $this->entityManager->find(JobType::class, $id);

		(new JobTypeValidator($jobType->getCustomer(), $this->container, $jobType->getLocal()))
			->setForcedProperties($options->getPropertiesScheduledToClear())
			->validate($persistable, true);

		$nullable = array_filter($options->getPropertiesScheduledToClear(), function($field){
			return !in_array($field, ['isPayable', 'isCommercial']);
		});

		$this->exchange($persistable, $jobType, $nullable);

		$this->entityManager->flush();
	}

	/**
	 * @param JobTypePersistable $persistable
	 * @param JobType $jobType
	 * @param array $nullable
	 */
	private function exchange(JobTypePersistable $persistable, JobType $jobType, array $nullable = [])
	{
		$this->transfer($persistable, $jobType, [
			'ignore' => ['local']
		]);


		if ($persistable->getLocal()){
			/**
			 * @var Local $local
			 */
			$local = $this->entityManager
				->getReference(Local::class, $persistable->getLocal());

			$jobType->setLocal($local);
		}

		if (in_array('local', $nullable)){
			$jobType->setLocal(null);
		}

	}

	/**
	 * @param int $id
	 */
	public function delete($id)
	{
		/**
		 * @var JobType $jobType
		 */
		$jobType = $this->entityManager->find(JobType::class, $id);

		$this->entityManager->getRepository(CustomerFee::class)->delete(['jobType' => $id]);

		$jobType->setHidden(true);

		$this->entityManager->flush();
	}
}