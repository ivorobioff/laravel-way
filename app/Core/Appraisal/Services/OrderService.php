<?php
namespace RealEstate\Core\Appraisal\Services;

use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Restate\Libraries\Validation\PresentableException;
use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraisal\Criteria\FilterResolver;
use RealEstate\Core\Appraisal\Criteria\SorterResolver;
use RealEstate\Core\Appraisal\Entities\AcceptedConditions;
use RealEstate\Core\Appraisal\Entities\SupportingDetails;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Appraisal\Entities\AdditionalExternalDocument;
use RealEstate\Core\Appraisal\Entities\Bid;
use RealEstate\Core\Appraisal\Entities\Contact;
use RealEstate\Core\Appraisal\Entities\Document;
use RealEstate\Core\Appraisal\Entities\Fdic;
use RealEstate\Core\Appraisal\Exceptions\AdditionalStatusForbiddenException;
use RealEstate\Core\Appraisal\Exceptions\WalletTransactionException;
use RealEstate\Core\Appraisal\Notifications\ReassignOrderNotification;
use RealEstate\Core\Appraisal\Objects\Payoff;
use RealEstate\Core\Appraisal\Validation\PayoffValidator;
use RealEstate\Core\Assignee\Services\NotificationSubscriptionService;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Company\Services\PermissionService;
use RealEstate\Core\Customer\Interfaces\WalletInterface;
use RealEstate\Core\Appraisal\Notifications\AwardOrderNotification;
use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;
use RealEstate\Core\Appraisal\Notifications\PayTechFeeNotification;
use RealEstate\Core\Appraisal\Objects\Totals;
use RealEstate\Core\Appraisal\Options\CreateDocumentOptions;
use RealEstate\Core\Appraisal\Options\CreateMessageOptions;
use RealEstate\Core\Appraisal\Persistables\AcceptedConditionsPersistable;
use RealEstate\Core\Appraisal\Persistables\AdditionalDocumentPersistable;
use RealEstate\Core\Appraisal\Persistables\CreateOrderPersistable;
use RealEstate\Core\Appraisal\Persistables\DocumentPersistable;
use RealEstate\Core\Appraisal\Persistables\FdicPersistable;
use RealEstate\Core\Appraisal\Persistables\MessagePersistable;
use RealEstate\Core\Appraisal\Persistables\UpdateOrderPersistable;
use RealEstate\Core\Appraisal\Validation\CreateOrderValidator;
use RealEstate\Core\Appraisal\Validation\UpdateOrderValidator;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Client;
use RealEstate\Core\Customer\Entities\Ruleset;
use RealEstate\Core\Customer\Objects\PayoffPurchase;
use RealEstate\Core\Customer\Services\AdditionalStatusService;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Appraisal\Entities\InstructionExternalDocument;
use RealEstate\Core\Appraisal\Entities\Message;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Property;
use RealEstate\Core\Appraisal\Enums\DeclineReason;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Exceptions\OperationNotPermittedWithCurrentProcessStatusException;
use RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification;
use RealEstate\Core\Appraisal\Notifications\BidRequestNotification;
use RealEstate\Core\Appraisal\Notifications\CreateOrderNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;
use RealEstate\Core\Appraisal\Notifications\DeclineOrderNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Appraisal\Objects\Conditions;
use RealEstate\Core\Appraisal\Options\CreateOrderOptions;
use RealEstate\Core\Appraisal\Options\FetchOrdersOptions;
use RealEstate\Core\Appraisal\Persistables\AbstractOrderPersistable;
use RealEstate\Core\Appraisal\Persistables\PropertyPersistable;
use RealEstate\Core\Appraisal\Validation\ConditionsValidator;
use RealEstate\Core\Customer\Entities\AdditionalDocumentType;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Invitation\Persistables\InvitationPersistable;
use RealEstate\Core\Invitation\Services\InvitationService;
use RealEstate\Core\Location\Entities\County;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Interfaces\GeocodingInterface;
use RealEstate\Core\Location\Objects\Location;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Log\Services\LogService;
use RealEstate\Core\Payment\Enums\Means;
use RealEstate\Core\Payment\Objects\Purchase;
use RealEstate\Core\Payment\Services\PaymentService;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\Support\Service\AbstractService;
use DateTime;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\ActorProviderInterface;
use RealEstate\Support\Tracker;
use Exception;
use Log;
use RealEstate\Core\Log\Entities\Log as Record;
/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrderService extends AbstractService
{
	use CommonsTrait;

	/**
	 * @param int $assigneeId
	 * @param FetchOrdersOptions $options
	 * @return Order[]
	 */
	public function getAllByAssigneeId($assigneeId, FetchOrdersOptions $options = null)
	{
		if ($options === null){
			$options = new FetchOrdersOptions();
		}

		$builder = $this->startQuery($assigneeId);

        if (!$builder){
            return [];
        }

        $this->applyCriteria($builder, $options->getCriteria())
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
        $builder = $this->startQuery($assigneeId, null, true);

        if (!$builder){
            return 0;
        }

        $this->applyCriteria($builder, $criteria);

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $customerId
     * @param int $assigneeId
     * @param FetchOrdersOptions $options
     * @return Order[]
     */
	public function getAllByCustomerAndAssigneeIds($customerId, $assigneeId, FetchOrdersOptions $options = null)
    {
        if ($options === null){
            $options = new FetchOrdersOptions();
        }

        $builder = $this->startQuery($assigneeId, $customerId);

        if (!$builder){
            return [];
        }


        $this->applyCriteria($builder, $options->getCriteria())
            ->withSorter($builder, $options->getSortables(), new SorterResolver());

        return (new Paginator())->apply($builder, $options->getPagination());
    }

    /**
     * @param int $customerId
     * @param int $assigneeId
     * @param array $criteria
     * @return int
     */
    public function getTotalByCustomerAndAssigneeIds($customerId, $assigneeId, array $criteria = [])
    {
        $builder = $this->startQuery($assigneeId, $customerId, true);

        if (!$builder){
            return 0;
        }

        $this->applyCriteria($builder, $criteria);

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $orderId
     * @param int $assigneeId
     * @param bool $withSubordinates
     * @return bool
     */
    public function existsByAssigneeId($orderId, $assigneeId, $withSubordinates = false)
    {
        if ($withSubordinates){
            $assigneeIds = $this->withSubordinateAssigneeIds($assigneeId);
        } else {
            $assigneeIds = [$assigneeId];
        }

        if (!$assigneeIds){
            return false;
        }

        return $this->entityManager->getRepository(Order::class)->exists([
            'id' => $orderId, 'assignee' => ['in', $assigneeIds]
        ]);
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @param bool $isCount
     * @return QueryBuilder
     */
    private function startQuery($assigneeId, $customerId = null, $isCount = false)
    {
        $assigneeIds = $this->withSubordinateAssigneeIds($assigneeId);

        if (!$assigneeIds){
            return null;
        }

        $builder = $this->entityManager->createQueryBuilder();

        $builder->select($isCount ? $builder->expr()->countDistinct('o'): 'o')->from(Order::class, 'o');

        $builder->andWhere($builder->expr()->in('o.assignee', ':assignees'))
            ->setParameter('assignees', $assigneeIds);

        if ($customerId){
            $builder->andWhere($builder->expr()->eq('o.customer', ':customer'))
                ->setParameter('customer', $customerId);
        }

        return $builder;
    }

    /**
     * @param int $assigneeId
     * @return User[]|Appraiser[]|Amc[]
     */
    private function withSubordinateAssigneeIds($assigneeId)
    {
        /**
         * @var PermissionService $permissionService
         */
        $permissionService = $this->container->get(PermissionService::class);

        $assignees = $permissionService->getAllAppraisersByManagerId($assigneeId);

        $ids = array_map(function(Appraiser $appraiser){
            return $appraiser->getId();
        }, $assignees);

        /**
         * @var User $assignee
         */
        $assignee = $this->entityManager->find(User::class, $assigneeId);

        $ids[] = $assignee->getId();

        return $ids;
    }

	/**
	 * @param QueryBuilder $builder
	 * @param Criteria[] $criteria
	 * @return Filter
	 */
	private function applyCriteria(QueryBuilder $builder, array $criteria)
	{
		return (new Filter())->apply($builder, $criteria, new FilterResolver());
	}

	/**
	 * @param int $id
	 * @return Order
	 */
	public function get($id)
	{
		return $this->entityManager->find(Order::class, $id);
	}

	/**
	 * @param int $customerId
	 * @param int $assigneeId
	 * @param CreateOrderPersistable $persistable
	 * @param CreateOrderOptions $options
	 * @return Order
	 */
	public function create($customerId, $assigneeId, CreateOrderPersistable $persistable, CreateOrderOptions $options = null)
	{
		if ($options === null){
			$options = new CreateOrderOptions();
		}

		$isBidRequest = false;

        if ($persistable->isBidRequest()){
            $isBidRequest = true;
        }

		/**
		 * @var Customer $customer
		 */
		$customer = $this->entityManager->getReference(Customer::class, $customerId);

        (new CreateOrderValidator($this->container, $customer, $isBidRequest))->validate($persistable);

		$order = new Order();

		if ($isBidRequest){
			$notification = new BidRequestNotification($order);
		} else {
			$notification = new CreateOrderNotification($order);
		}

        if ($options->isFromStaff()){
            /**
             * @var Staff $staff
             */
            $staff = $this->entityManager->find(Staff::class, $assigneeId);

            $assignee = $staff->getUser();
            $assigneeId = $assignee->getId();
        } else {
            $staff = null;

            /**
             * @var Appraiser|Amc $assignee
             */
            $assignee = $this->entityManager->find(User::class, $assigneeId);
        }

		/**
		 * @var CustomerService $customerService
		 */
		$customerService = $this->container->get(CustomerService::class);

		if ($assignee instanceof Appraiser){

			if (!$customerService->isRelatedWithAppraiser($customerId, $assigneeId)){
				/**
				 * @var InvitationService $invitationService
				 */
				$invitationService = $this->container->get(InvitationService::class);

				$invitation = $invitationService->getSharedAmongCustomerAndAppraiser($customerId, $assigneeId);

				if ($invitation === null){

                    $invitationPersistable = $persistable->getInvitation() ?? new InvitationPersistable();
                    $invitationPersistable->setAppraiser($assigneeId);

                    $invitation = $invitationService->create($customerId, $invitationPersistable);
                    $notification->withInvitation($invitation);
				}

				$order->setInvitation($invitation);
			}
		} elseif ($assignee instanceof Amc){
			if (!$customerService->isRelatedWithAmc($customerId, $assigneeId)){
				$customerService->relateWithAmc($customerId, $assigneeId);
			}
		} elseif ($assignee instanceof Manager){
            /**
             * @var NotificationSubscriptionService $notificationSubscriptionService
             */
            $notificationSubscriptionService = $this->container->get(NotificationSubscriptionService::class);
            $notificationSubscriptionService->subscribeIfNot($assigneeId, $customerId);
        }

        $order->setAssignee($assignee);

		if ($options->isFromStaff()){
            $order->setStaff($staff);
        }

		$order->setCustomer($customer);

		if ($isBidRequest){
			$order->setProcessStatus(new ProcessStatus(ProcessStatus::REQUEST_FOR_BID));
		} else {
			$order->setProcessStatus(new ProcessStatus(ProcessStatus::FRESH));

			if ($persistable->getAssignedAt() !== null){
				$order->setAssignedAt($persistable->getAssignedAt());
			} else {
				$order->setAssignedAt(new DateTime());
			}
		}

		$this->save($persistable, $order);

        $supportingDetails = new SupportingDetails();
        $supportingDetails->setOrder($order);

        $this->entityManager->persist($supportingDetails);
        $this->entityManager->flush();

		$this->notify($notification);

		return $order;
	}

	/**
	 * @param int $id
	 * @param UpdateOrderPersistable $persistable
	 * @param UpdateOptions $options
	 * @throws ErrorsThrowableCollection
	 */
	public function update($id, UpdateOrderPersistable $persistable, UpdateOptions $options = null)
	{
		if ($options === null){
			$options = new UpdateOptions();
		}

		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

        $nullable = array_filter($options->getPropertiesScheduledToClear(), function($value){
            return !in_array($value, ['isRush']);
        });

		(new UpdateOrderValidator(
			$this->container,
			$order->getCustomer(),
			$order->getProcessStatus()->is(ProcessStatus::REQUEST_FOR_BID)
		))
			->setForcedProperties($nullable)
			->validateWithOrder($persistable, $order);

		$this->save($persistable, $order, $nullable);

		$this->notify(new UpdateOrderNotification($order));
	}

	/**
	 * @param AbstractOrderPersistable|UpdateOrderPersistable|CreateOrderPersistable $persistable
	 * @param Order $order
	 * @param array $nullable
	 */
	private function save(AbstractOrderPersistable $persistable, Order $order, array $nullable = [])
	{
		if ($order->getId() !== null){
			$order->setUpdatedAt(new DateTime());
		}

		$this->transfer($persistable, $order, [
			'ignore' => [
				'client',
				'clientDisplayedOnReport',
				'jobType',
				'property',
				'additionalDocuments',
				'instructionDocuments',
				'contractDocument',
				'assignedAt',
				'acceptedConditions',
				'rulesets',
				'additionalJobTypes',
                'fdic',
                'invitation'
			],
			'nullable' => $nullable
		]);

		if ($client = $persistable->getClient()){

			/**
			 * @var Client $client
			 */
			$client = $this->entityManager->getReference(Client::class, $client);
			$order->setClient($client);
		}


		if ($clientDisplayedOnReport = $persistable->getClientDisplayedOnReport()){
			/**
			 * @var Client $clientDisplayedOnReport
			 */
			$clientDisplayedOnReport = $this->entityManager->getReference(Client::class, $clientDisplayedOnReport);
			$order->setClientDisplayedOnReport($clientDisplayedOnReport);
		}

		if ($persistable->getJobType()){
			/**
			 * @var JobType $jobType
			 */
			$jobType = $this->entityManager->getReference(JobType::class, $persistable->getJobType());

			$order->setJobType($jobType);
		}

		if ($persistable->getAdditionalJobTypes() !== null){
			$jobTypes = [];

			foreach ($persistable->getAdditionalJobTypes() as $jobTypeId){
				$jobTypes[] = $this->entityManager->getReference(JobType::class, $jobTypeId);
			}

			$order->setAdditionalJobTypes($jobTypes);
		}

		if ($persistable->getRulesets() !== null){
			$rulesets = [];

			foreach ($persistable->getRulesets() as $ruleset){
				$rulesets[] = $this->entityManager->getReference(Ruleset::class, $ruleset);
			}

			$order->setRulesets($rulesets);
		}

		if (!$order->getId()){
			$this->entityManager->persist($order);
			$this->entityManager->flush();
		}

		if ($contractDocument = $persistable->getContractDocument()) {

			if ($contractDocument instanceof AdditionalDocumentPersistable){
				$contractDocument = $this->createAdditionalDocumentInMemory($order, $contractDocument, $this->container);
				$this->entityManager->persist($contractDocument);
				$this->entityManager->flush();
			} else {
				/**
				 * @var AdditionalDocument $contractDocument
				 */
				$contractDocument = $this->entityManager->getReference(AdditionalDocument::class, $contractDocument);
			}

			$order->setContractDocument($contractDocument);
		}

		if (in_array('contractDocument', $nullable)){
			$order->setContractDocument(null);
		}

		if (in_array('fdic', $nullable)){
            if ($fdic = $order->getFdic()){
                $this->entityManager->remove($fdic);
                $order->setFdic(null);
            }
        } else {
            $fdicNullable = array_map(function($value){
                return cut_string_left($value, 'fdic.');
            }, array_filter($nullable, function($value){
                return starts_with($value, 'fdic.');
            }));

            if ($persistable->getFdic() || $fdicNullable){

                $fdic = $order->getFdic() ?? new Fdic();
                $order->setFdic($fdic);

                $fdicPersistable = $persistable->getFdic() ?? new FdicPersistable();
                $this->saveFdic($fdicPersistable, $fdic, $fdicNullable);
            }
        }

		$propertyNullable = array_map(function($value){
			return cut_string_left($value, 'property.');
		}, array_filter($nullable, function($value){
            return starts_with($value, 'property.');
        }));


		if ($persistable->getProperty() || $propertyNullable){

			$property = $order->getProperty() ?? new Property();
			$order->setProperty($property);

			$propertyPersistable = $persistable->getProperty() ?? new PropertyPersistable();

			$this->saveProperty($propertyPersistable, $property, $propertyNullable);
		}

		if ($persistable->getAdditionalDocuments() !== null){

			if ($order->hasAdditionalDocuments()){
				$this->entityManager
					->getRepository(AdditionalExternalDocument::class)
					->delete(['order' => $order->getId()]);

				$order->clearAdditionalDocuments();
			}

			foreach ($persistable->getAdditionalDocuments() as $documentPersistable){
				$document = new AdditionalExternalDocument();
				$this->transfer($documentPersistable, $document);
				$order->addAdditionalDocument($document);
				$this->entityManager->persist($document);
			}
		}

		if ($persistable->getInstructionDocuments() !== null){

			if ($order->hasInstructionDocuments()){
				$this->entityManager
					->getRepository(InstructionExternalDocument::class)
					->delete(['order' => $order->getId()]);

				$order->clearInstructionDocuments();
			}

			foreach ($persistable->getInstructionDocuments() as $documentPersistable){
				$document = new InstructionExternalDocument();
				$this->transfer($documentPersistable, $document);
				$order->addInstructionDocument($document);
				$this->entityManager->persist($document);
			}
		}

		$acceptedConditionsNullable = array_filter($nullable, function($value){
			return starts_with($value, 'acceptedConditions.');
		});

		$acceptedConditionsNullable = array_map(function($value){
			return cut_string_left($value, 'acceptedConditions.');
		}, $acceptedConditionsNullable);

		if ($persistable->getAcceptedConditions() || $acceptedConditionsNullable){

			$acceptedConditions = $order->getAcceptedConditions() ?? new AcceptedConditions();
			$acceptedConditionsPersistable = $persistable->getAcceptedConditions() ?? new AcceptedConditionsPersistable();

			/**
			 * @var AcceptedConditions $acceptedConditions
			 */
			$acceptedConditions = $this->transfer($acceptedConditionsPersistable, $acceptedConditions, [
				'nullable' => $acceptedConditionsNullable
			]);

			if (!$acceptedConditions->getId()){
				$this->entityManager->persist($acceptedConditions);
				$this->entityManager->flush();
			}

			$order->setAcceptedConditions($acceptedConditions);
		}

		$this->entityManager->flush();
	}

	/**
	 * @param int $orderId
	 * @param ProcessStatus $processStatus
	 */
	public function updateProcessStatus($orderId, ProcessStatus $processStatus)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		list($oldProcessStatus, $newProcessStatus) = $this->handleProcessStatusTransitionInMemory(
			$order, $processStatus, $this->container);
		
		$this->entityManager->flush();

		$this->notify(new UpdateProcessStatusNotification($order, $oldProcessStatus, $newProcessStatus));
	}

    /**
     * @param FdicPersistable $persistable
     * @param Fdic $fdic
     * @param array $nullable
     */
	private function saveFdic(FdicPersistable $persistable, Fdic $fdic, array $nullable = [])
    {
        $this->transfer($persistable, $fdic, [
            'nullable' => $nullable
        ]);

        if ($fdic->getId() === null){
            $this->entityManager->persist($fdic);
        }

        $this->entityManager->flush();
    }

	/**
	 * @param PropertyPersistable $persistable
	 * @param Property $property
	 * @param array $nullable
	 */
	private function saveProperty(PropertyPersistable $persistable, Property $property, array $nullable = [])
	{
	    $nullable = array_filter($nullable, function($value){
            return !in_array($value, ['characteristics']);
        });

		$this->transfer($persistable, $property, [
			'ignore' => [
				'state',
				'county',
				'contacts'
			],
			'nullable' => $nullable
		]);

		if ($persistable->getState()){
			/**
			 * @var State $state
			 */
			$state = $this->entityManager->getReference(State::class, $persistable->getState());

			$property->setState($state);
		}

		if ($persistable->getCounty()){
			/**
			 * @var County $county
			 */
			$county = $this->entityManager->getReference(County::class, $persistable->getCounty());

			$property->setCounty($county);
		}

		if (!$property->getId()){
			$this->entityManager->persist($property);
			$this->entityManager->flush();
		}

		if ($persistable->getContacts() !== null){

			if ($property->hasContacts()){

				$this->entityManager
					->getRepository(Contact::class)
					->delete(['property' => $property->getId()]);

				$property->clearContacts();
			}

			foreach ($persistable->getContacts() as $contactPersistable){
				$contact = new Contact();
				$this->transfer($contactPersistable, $contact);
				$property->addContact($contact);
				$this->entityManager->persist($contact);
			}
		}

		if ($persistable->getAddress1() !== null
			|| $persistable->getAddress2() !== null
			|| $persistable->getState() !== null
			|| $persistable->getCity() !== null
			|| $persistable->getZip() !== null){

			$this->tryDefineCoordinates($property);
		}

		$this->entityManager->flush();
	}


	/**
	 * @param Property $property
	 */
	private function tryDefineCoordinates(Property $property)
	{
		/**
		 * @var GeocodingInterface $geocoding
		 */
		$geocoding = $this->container->get(GeocodingInterface::class);

		$location = new Location();

		$location->setAddress1($property->getAddress1());
		$location->setAddress2($property->getAddress2());
		$location->setCity($property->getCity());
		$location->setState($property->getState()->getCode());
		$location->setZip($property->getZip());

		if ($coordinates = $geocoding->toCoordinates($location)){
			$property->setLatitude($coordinates->getLatitude());
			$property->setLongitude($coordinates->getLongitude());
		}
	}

	/**
	 * @param int $id
	 */
	public function accept($id)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

		if ($order->getAssignee() instanceof Appraiser){
			$this->handleInvitationInOrder($order, $this->container);
		}

		$this->updateProcessStatus($id, new ProcessStatus(ProcessStatus::ACCEPTED));
	}

	/**
	 * @param int $id
	 * @param Conditions $conditions
	 */
	public function acceptWithConditions($id, Conditions $conditions)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

		if (!$order->getProcessStatus()->is(ProcessStatus::FRESH)){
			throw new OperationNotPermittedWithCurrentProcessStatusException();
		}

		(new ConditionsValidator())->validate($conditions);

		$this->notify(new AcceptOrderWithConditionsNotification($order, $conditions));

		$this->delete($id, true);
	}

	/**
	 * @param int $id
	 * @param DateTime $assignedAt
	 */
	public function award($id, DateTime $assignedAt = null)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

		if (!$order->getProcessStatus()->is(ProcessStatus::REQUEST_FOR_BID)){
			throw new OperationNotPermittedWithCurrentProcessStatusException();
		}

		if ($order->getBid() === null){
			throw new PresentableException('The bid has not been submitted.');
		}

		$bid = $order->getBid();
		$settings = $order->getCustomer()->getSettings();

		$order->setProcessStatus(new ProcessStatus(ProcessStatus::FRESH));
		$order->setFee($bid->getAmount());

		if ($bid->getEstimatedCompletionDate()){
			$order->setEstimatedCompletionDate($bid->getEstimatedCompletionDate());

			$dueDate = new DateTime($bid->getEstimatedCompletionDate()->format(DateTime::ATOM));

			$dueDate->modify('+'.$settings->getDaysPriorEstimatedCompletionDate().' days');

			$order->setDueDate($dueDate);
		}

		if ($assignedAt !== null){
			$order->setAssignedAt($assignedAt);
		} else {
			$order->setAssignedAt(new DateTime());
		}

		$order->setBid(null);

		$this->entityManager->remove($bid);

		$this->entityManager->flush();


        $this->notify(new AwardOrderNotification($order));
	}

	/**
	 * @param int $id
	 * @param DeclineReason $reason
	 * @param string $message
	 */
	public function decline($id, DeclineReason $reason, $message = null)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

		if (!$order->getProcessStatus()->is([ProcessStatus::FRESH, ProcessStatus::REQUEST_FOR_BID])){
			throw new OperationNotPermittedWithCurrentProcessStatusException();
		}

		$this->notify(new DeclineOrderNotification($order, $reason, $message));

		$this->delete($id, true);
	}

	/**
	 * @param int $id
	 * @param bool $keepSilence
	 */
	public function delete($id, $keepSilence = false)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $id);

		$order->setContractDocument(null);

		$this->entityManager->flush();

		/**
		 * @var DocumentService $documentService
		 */
		$documentService = $this->container->get(DocumentService::class);
		$documentService->deleteAll($id);

		/**
		 * @var AdditionalDocumentService $additionalDocumentService
		 */
		$additionalDocumentService = $this->container->get(AdditionalDocumentService::class);
		$additionalDocumentService->deleteAll($id);

		/**
		 * @var RevisionService $revisionService
		 */
		$revisionService = $this->container->get(RevisionService::class);
		$revisionService->deleteAll($id);

		/**
		 * @var ReconsiderationService $reconsiderationService
		 */
		$reconsiderationService = $this->container->get(ReconsiderationService::class);
		$reconsiderationService->deleteAll($id);

		/**
		 * @var MessageService $messageService
		 */
		$messageService = $this->container->get(MessageService::class);
		$messageService->deleteAll($id);

		/**
		 * @var LogService $logService
		 */
		$logService = $this->container->get(LogService::class);
		$logService->deleteAllByOrderId($id);

		if ($keepSilence === false){
			$this->notify(new DeleteOrderNotification($order));
		}

		$this->entityManager->remove($order);
		$this->entityManager->flush();
	}

	/**
	 * @param int $orderId
	 * @param DocumentPersistable $persistable
	 * @param CreateDocumentOptions $options
	 * @return Document
	 */
	public function proceedWithDocument($orderId, DocumentPersistable $persistable, CreateDocumentOptions $options = null)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

        if ($order->getProcessStatus()->is(ProcessStatus::COMPLETED)){
            throw new PresentableException('The document cannot be uploaded for the order in the "completed" process status.');
        }

		if ($order->needToPayTechFee() && $order->getAssignee() instanceof Appraiser){
			throw new PresentableException('The document cannot be upload until tech fee is paid.');
		}

		$oldProcessStatus = $order->getProcessStatus();
		$newProcessStatus = $oldProcessStatus;

		/**
		 * @var DocumentService $documentService
		 */
		$documentService = $this->container->get(DocumentService::class);

		$document = $documentService->create($orderId, $persistable, $options);

		if ($order->getWorkflow()->has(new ProcessStatus(ProcessStatus::REVISION_PENDING))){
			$newProcessStatus = new ProcessStatus(ProcessStatus::REVISION_IN_REVIEW);
		} elseif (!$order->getWorkflow()->has(new ProcessStatus(ProcessStatus::READY_FOR_REVIEW))){
			$newProcessStatus = new ProcessStatus(ProcessStatus::READY_FOR_REVIEW);
		}

		$isProcessStatusChanged = (string) $oldProcessStatus !== (string) $newProcessStatus;

		if ($isProcessStatusChanged){
			$order->setProcessStatus($newProcessStatus);
		}

		$this->entityManager->flush();

		if ($isProcessStatusChanged){
			$this->notify(new UpdateProcessStatusNotification($order, $oldProcessStatus, $newProcessStatus));
		}

		return $document;
	}


	/**
	 * @param $orderId
	 * @return bool
	 */
	public function hasDocuments($orderId)
	{
		return $this->entityManager
			->getRepository(Document::class)
			->exists(['order' => $orderId]);
	}

	/**
	 * @param int $orderId
	 * @param int $documentId
	 * @return bool
	 */
	public function hasDocument($orderId, $documentId)
	{
		return $this->entityManager
			->getRepository(Document::class)
			->exists(['order' => $orderId, 'id' => $documentId]);
	}

	/**
	 * @param int $orderId
	 * @param int $documentId
	 * @return bool
	 */
	public function hasAdditionalDocument($orderId, $documentId)
	{
		return $this->entityManager
			->getRepository(AdditionalDocument::class)
			->exists(['order' => $orderId, 'id' => $documentId]);
	}

	/**
	 * @param int $orderId
	 * @param int $typeId
	 * @return bool
	 */
	public function hasAdditionalDocumentType($orderId, $typeId)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		return $this->entityManager
			->getRepository(AdditionalDocumentType::class)
			->exists(['id' => $typeId, 'customer' =>  $order->getCustomer()->getId()]);
	}

	/**
	 * @param int $orderId
	 * @param string $explanation
	 */
	public function postpone($orderId, $explanation)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		$oldProcessStatus = $order->getProcessStatus();
		$newProcessStatus = new ProcessStatus(ProcessStatus::ON_HOLD);

		$order->setProcessStatus($newProcessStatus);
		$order->setComment($explanation);

		$order->setPutOnHoldAt($this->environment->getLogCreatedAt() ?? new DateTime());

		$this->entityManager->flush();

		$this->notify(new UpdateProcessStatusNotification($order, $oldProcessStatus, $newProcessStatus));

		if ($explanation !== null){
			/**
			 * @var MessageService $messageService
			 */
			$messageService = $this->container->get(MessageService::class);

			$message = new MessagePersistable();
			$message->setContent($explanation);

			$options = new CreateMessageOptions();
			$options->setTrusted(true);

			/**
			 * @var ActorProviderInterface $actorProvider
			 */
			$actorProvider = $this->container->get(ActorProviderInterface::class);

			$messageService->create($actorProvider->getActor()->getId(), $orderId, $message, $options);
		}
	}

	/**
	 * @param int $orderId
	 * @param int $messageId
	 * @return bool
	 */
	public function hasMessage($orderId, $messageId)
	{
		return $this->entityManager->getRepository(Message::class)
			->exists(['order' => $orderId, 'id' => $messageId]);
	}

	/**
	 * @param int $orderId
	 * @return bool
	 */
	public function hasBid($orderId)
	{
		return $this->entityManager->getRepository(Bid::class)->exists(['order' => $orderId]);
	}

    /**
     * @param int $assigneeId
     * @param Criteria[] $criteria
     * @return Totals
     */
    public function getPaidTotalsByAssigneeId($assigneeId, array $criteria = [])
    {
        return $this->calculatePaidOrUnpaidByAssigneeId(true, $assigneeId, null, $criteria);
    }

    /**
     * @param int $assigneeId
     * @param Criteria[] $criteria
     * @return Totals
     */
    public function getUnpaidTotalsByAssigneeId($assigneeId, array $criteria = [])
    {
        return $this->calculatePaidOrUnpaidByAssigneeId(false, $assigneeId, null, $criteria);
    }

	/**
     * @param int $customerId
	 * @param int $assigneeId
	 * @return Totals
	 */
	public function getPaidTotalsByCustomerAndAssigneeIds($customerId, $assigneeId)
	{
		return $this->calculatePaidOrUnpaidByAssigneeId(true, $assigneeId, $customerId);
	}

	/**
     * @param int $customerId
	 * @param int $assigneeId
	 * @return Totals
	 */
	public function getUnpaidTotalsByCustomerAndAssigneeIds($customerId, $assigneeId)
	{
		return $this->calculatePaidOrUnpaidByAssigneeId(false, $assigneeId, $customerId);
	}

	/**
	 * @param bool $paid
	 * @param int $assigneeId
     * @param int $customerId
     * @param Criteria[] $criteria
	 * @return Totals
	 */
	private function calculatePaidOrUnpaidByAssigneeId($paid, $assigneeId, $customerId = null, array $criteria = [])
	{
		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select($builder->expr()->count('o'), 'SUM(o.fee)', 'SUM(o.techFee)')
			->from(Order::class, 'o')
			->where($builder->expr()->eq('o.assignee', ':assignee'))
			->andWhere($builder->expr()->eq('o.isPaid', ':paid'))
            ->setParameter('assignee', $assigneeId)
            ->setParameter('paid', $paid);

        if ($customerId){
            $builder
                ->andWhere($builder->expr()->eq('o.customer', ':customer'))
                ->setParameter('customer', $customerId);
        }

        $this->applyCriteria($builder, $criteria);

        $data = $builder->getQuery()->getArrayResult();

		$totals = new Totals();

		$data = array_values($data[0]);
		$totals->setTotal((int)$data[0]);
		$totals->setFee((float)$data[1]);
		$totals->setTechFee((float) $data[2]);

		return $totals;
	}

	/**
	 * @param int $orderId
	 */
	public function payTechFee($orderId)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		if ($order->getTechFee() === null){
			throw new PresentableException('The tech fee is not specified, therefore, there is nothing to pay for.');
		}

		if ($order->isTechFeePaid()){
			throw new PresentableException('The tech fee has already been paid.');
		}

		if (!$this->environment->isRelaxed()){
			/**
			 * @var PaymentService $paymentService
			 */
			$paymentService = $this->container->get(PaymentService::class);

            $purchase = new Purchase();
            $purchase->setPrice($order->getTechFee());
            $purchase->setProduct($order);

			$paymentService->charge($order->getAssignee()->getId(), $purchase, new Means(Means::CREDIT_CARD));
		}

		$order->setTechFeePaid(true);

		$this->entityManager->flush();

		$this->notify(new PayTechFeeNotification($order));
	}

	/**
	 * @param int $orderId
	 * @param int $additionalStatusId
	 * @param string $comment
	 */
	public function changeAdditionalStatus($orderId, $additionalStatusId, $comment = null)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		/**
		 * @var CustomerService $customerService
		 */
		$customerService = $this->container->get(CustomerService::class);

		if (!$customerService->hasActiveAdditionalStatus($order->getCustomer()->getId(), $additionalStatusId)){
			throw new AdditionalStatusForbiddenException();
		}

		$notification = new ChangeAdditionalStatusNotification($order);
		$notification->setOldAdditionalStatus($order->getAdditionalStatus(), $order->getAdditionalStatusComment());

		/**
		 * @var AdditionalStatus $additionalStatus
		 */
		$additionalStatus = $this->entityManager->find(AdditionalStatus::class, $additionalStatusId);

		$order->setAdditionalStatus($additionalStatus);
		$order->setAdditionalStatusComment($comment);
		$notification->setNewAdditionalStatus($additionalStatus, $comment);

		$this->entityManager->flush();

		$this->notify($notification);
	}

	/**
	 * @param int $orderId
	 * @return AdditionalStatus[]
	 */
	public function getAllActiveAdditionalStatuses($orderId)
	{
		/**
		 * @var AdditionalStatusService $additionalStatusService
		 */
		$additionalStatusService = $this->container->get(AdditionalStatusService::class);

		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		return $additionalStatusService->getAllActive($order->getCustomer()->getId());
	}

	/**
	 * Moves all orders that passed due to the "Late" queue
	 */
	public function moveAllPassedDueToLateQueue()
	{
		$builder = $this->entityManager->createQueryBuilder();

		$iterator = $builder
			->from(Order::class, 'o')
			->select('o')
			->where($builder->expr()->isNotNull('o.dueDate'))
			->andWhere($builder->expr()->lt('o.dueDate', ':current'))
			->andWhere($builder->expr()->in('o.processStatus', ':processStatuses'))
			->setParameters([
				'current' => new DateTime((new DateTime())->format('Y-m-d 00:00:00')),
				'processStatuses' => ProcessStatus::dueToArray()
			])
			->getQuery()
			->iterate();

		
		foreach ($tracker = new Tracker($iterator, 100) as $item){

			/**
			 * @var Order $order
			 */
			$order = $item[0];

			$oldProcessStatus = $order->getProcessStatus();
			$newProcessStatus = new ProcessStatus(ProcessStatus::LATE);

			$order->setProcessStatus($newProcessStatus);

			$this->notify(new UpdateProcessStatusNotification($order, $oldProcessStatus, $newProcessStatus));

			if ($tracker->isTime()){
				$this->entityManager->flush();
				$this->entityManager->clear();
			}
		}

		$this->entityManager->flush();
	}


	public function fixPropertiesCoordinates()
	{
		$builder =  $this->entityManager->createQueryBuilder();

		$iterator = $builder
			->from(Order::class, 'o')
			->select('o', 'p')
			->leftJoin('o.property', 'p')
			->where('p.latitude IS NULL OR p.longitude IS NULL')
			->getQuery()
			->iterate();

		foreach ($tracker = new Tracker($iterator, 100) as $item){

			/**
			 * @var Order $order
			 */
			$order = $item[0];

			$this->tryDefineCoordinates($order->getProperty());

			if ($tracker->isTime()){
				$this->entityManager->flush();
				$this->entityManager->clear();
			}
		}

		$this->entityManager->flush();
	}

    /**
     * @param int $orderId
     * @param Payoff $payoff
     */
    public function payoff($orderId, Payoff $payoff)
    {
        (new PayoffValidator($this->container->get(StateService::class)))->validate($payoff);

        /**
         * @var Order $order
         */
        $order = $this->entityManager->find(Order::class, $orderId);

        if (!$order->getAssignee() instanceof Amc){
            throw new PresentableException('Only AMCs can get paid this way.');
        }

        /**
         * @var WalletInterface $wallet
         */
        $wallet = $this->container->get(WalletInterface::class);

        $purchase = new PayoffPurchase();
        $purchase->setProduct($order);
        $purchase->setPrice($payoff->getAmount());

        try {
            $wallet->pay($payoff->getCreditCard(), $purchase);
        } catch (Exception $exception) {
            if ($exception instanceof PresentableException || $exception instanceof WalletTransactionException){
                throw $exception;
            } else {
                Log::warning($exception);
                throw new PresentableException('Unrecognized error. Please see the logs to get more details.');
            }
        }
    }

    /**
     * @param int $orderId
     * @param int $assigneeId
     */
    public function reassign($orderId, $assigneeId)
    {
        /**
         * @var Order $order
         */
        $order = $this->entityManager->find(Order::class, $orderId);

        /**
         * @var Appraiser $appraiser
         */
        $appraiser = $this->entityManager->getReference(Appraiser::class, $assigneeId);

        if (!$appraiser instanceof Appraiser){
            throw new PresentableException('The "'.$assigneeId.'" user is not an appraiser');
        }

        $oldAssignee = $order->getAssignee();

        $order->setAssignee($appraiser);

        $this->entityManager->flush();

        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->update(Record::class, 'l')
            ->set('l.assignee', ':assignee')
            ->andWhere($builder->expr()->eq('l.order', ':order'))
            ->getQuery()
            ->execute(['assignee' => $assigneeId, 'order' => $orderId]);

        $this->notify(new ReassignOrderNotification($order, $oldAssignee));
    }
}