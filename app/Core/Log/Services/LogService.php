<?php
namespace RealEstate\Core\Log\Services;

use Doctrine\DBAL\Query\QueryBuilder;
use RealEstate\Core\Appraisal\Notifications\AwardOrderNotification;
use RealEstate\Core\Appraisal\Notifications\BidRequestNotification;
use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;
use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\CreateOrderNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;
use RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification;
use RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Company\Services\PermissionService;
use RealEstate\Core\Log\Criteria\FilterResolver;
use RealEstate\Core\Log\Criteria\SorterResolver;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Factories\AwardOrderFactory;
use RealEstate\Core\Log\Factories\BidRequestFactory;
use RealEstate\Core\Log\Factories\ChangeAdditionalStatusFactory;
use RealEstate\Core\Log\Factories\CreateAdditionalDocumentFactory;
use RealEstate\Core\Log\Factories\CreateDocumentFactory;
use RealEstate\Core\Log\Factories\CreateOrderFactory;
use RealEstate\Core\Log\Factories\DeleteAdditionalDocumentFactory;
use RealEstate\Core\Log\Factories\DeleteDocumentFactory;
use RealEstate\Core\Log\Factories\DeleteOrderFactory;
use RealEstate\Core\Log\Factories\FactoryInterface;
use RealEstate\Core\Log\Factories\ReconsiderationRequestFactory;
use RealEstate\Core\Log\Factories\RevisionRequestFactory;
use RealEstate\Core\Log\Factories\UpdateDocumentFactory;
use RealEstate\Core\Log\Factories\UpdateOrderFactory;
use RealEstate\Core\Log\Factories\UpdateProcessStatusFactory;
use RealEstate\Core\Log\Notifications\CreateLogNotification;
use RealEstate\Core\Log\Options\FetchLogsOptions;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LogService extends AbstractService
{
	/**
	 * @var array
	 */
	private $factories = [
		CreateOrderNotification::class => CreateOrderFactory::class,
		BidRequestNotification::class => BidRequestFactory::class,
		UpdateProcessStatusNotification::class => UpdateProcessStatusFactory::class,
		DeleteOrderNotification::class => DeleteOrderFactory::class,
		UpdateOrderNotification::class => UpdateOrderFactory::class,
		CreateDocumentNotification::class => CreateDocumentFactory::class,
        UpdateDocumentNotification::class => UpdateDocumentFactory::class,
		DeleteDocumentNotification::class => DeleteDocumentFactory::class,
		CreateAdditionalDocumentNotification::class => CreateAdditionalDocumentFactory::class,
		DeleteAdditionalDocumentNotification::class => DeleteAdditionalDocumentFactory::class,
		ChangeAdditionalStatusNotification::class => ChangeAdditionalStatusFactory::class,
		RevisionRequestNotification::class => RevisionRequestFactory::class,
		ReconsiderationRequestNotification::class => ReconsiderationRequestFactory::class,
        AwardOrderNotification::class => AwardOrderFactory::class
	];

    /**
     * @param int $id
     * @return Log
     */
    public function get($id)
    {
        return $this->entityManager->find(Log::class, $id);
    }

	/**
	 * @param object $notification
	 * @return bool
	 */
	public function canCreate($notification)
	{
		$class = get_class($notification);

		if (!isset($this->factories[$class])){
			return false;
		}

		return class_exists($class);
	}

	/**
	 * @param object $notification
	 * @return Log
	 */
	public function create($notification)
	{
		$class = $this->factories[get_class($notification)];

		/**
		 * @var FactoryInterface $factory
		 */
		$factory = $this->container->get($class);

		$log = $factory->create($notification);

		$this->entityManager->persist($log);

		$this->entityManager->flush();

		$this->notify(new CreateLogNotification($log));

		return $log;
	}

	/**
	 * @param int $assigneeId
	 * @param FetchLogsOptions $options
	 * @return Log[]
	 */
	public function getAllByAssigneeId($assigneeId, FetchLogsOptions $options = null)
	{
		return $this->getAllByQuery(['assignee' => $assigneeId], $options);
	}

    /**
     * @param int $customerId
     * @param int $assigneeId
     * @param FetchLogsOptions $options
     * @return Log[]
     */
    public function getAllByCustomerAndAssigneeIds($customerId, $assigneeId, FetchLogsOptions $options = null)
    {
        return $this->getAllByQuery(['assignee' => $assigneeId, 'customer' => $customerId], $options);
    }

	/**
	 * @param int $orderId
	 * @param FetchLogsOptions $options
	 * @return Log[]
	 */
	public function getAllByOrderId($orderId, FetchLogsOptions $options = null)
	{
		return $this->getAllByQuery(['order' => $orderId], $options);
	}

	/**
	 * @param array $parameters
	 * @param FetchLogsOptions|null $options
	 * @return Log[]
	 */
	private function getAllByQuery(array $parameters, FetchLogsOptions $options = null)
	{
		if ($options === null){
			$options = new FetchLogsOptions();
		}

        $builder = $this->startQuery($parameters);

		(new Filter())->apply($builder, $options->getCriteria(), new FilterResolver())
			->withSorter($builder, $options->getSortables(), new SorterResolver());
		
		return (new Paginator())->apply($builder, $options->getPagination());
	}

	/**
	 * @param int $assigneeId
	 * @param Criteria[] $criteria
	 * @return int
	 */
	public function getTotalByAssigneeId($assigneeId, array $criteria = [])
	{
		return $this->getTotalByQuery(['assignee' => $assigneeId], $criteria);
	}

    /**
     * @param int $customerId
     * @param int $assigneeId
     * @param array $criteria
     * @return int
     */
	public function getTotalByCustomerAndAssigneeId($customerId, $assigneeId, array $criteria = [])
    {
        return $this->getTotalByQuery(['assignee' => $assigneeId, 'customer' => $customerId], $criteria);
    }

	/**
	 * @param int $orderId
	 * @param Criteria[] $criteria
	 * @return int
	 */
	public function getTotalByOrderId($orderId, array $criteria = [])
	{
		return $this->getTotalByQuery(['order' => $orderId], $criteria);
	}

	/**
	 * @param array $parameters
	 * @param Criteria[] $criteria
	 * @return int
	 */
	private function getTotalByQuery(array $parameters, array $criteria)
	{
        $builder = $this->startQuery($parameters, true);

		(new Filter())->apply($builder, $criteria, new FilterResolver());

		return (int) $builder->getQuery()->getSingleScalarResult();
	}

    /**
     * @param array $parameters
     * @param bool $isCount
     * @return QueryBuilder
     */
	private function startQuery(array $parameters, $isCount = false)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->select($isCount ? $builder->expr()->countDistinct('l') : 'l')
            ->from(Log::class, 'l');

        if (isset($parameters['assignee'])) {
            /**
             * @var PermissionService $permissionService
             */
            $permissionService = $this->container->get(PermissionService::class);

            $assigneeIds = array_map(function(Appraiser $appraiser){
                return $appraiser->getId();
            }, $permissionService->getAllAppraisersByManagerId($parameters['assignee']));

            $assigneeIds[] = $parameters['assignee'];

            $parameters['assignee'] = $assigneeIds;
        }

        foreach ($parameters as $name => $value) {
            $op = is_array($value) ? 'in' : 'eq';

            $builder->andWhere($builder->expr()->{$op}('l.'.$name, ':'.$name))
                ->setParameter($name, $value);
        }

        return $builder;
    }

	/**
	 * @param int $orderId
	 */
	public function deleteAllByOrderId($orderId)
	{
		$this->entityManager->getRepository(Log::class)->delete(['order' => $orderId]);
	}
}