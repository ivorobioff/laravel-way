<?php
namespace RealEstate\Core\Appraisal\Services;

use Doctrine\ORM\EntityManagerInterface;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Persistables\AdditionalDocumentPersistable;
use RealEstate\Core\Customer\Entities\AdditionalDocumentType;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\Core\Invitation\Services\InvitationService;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Support\Service\ContainerInterface;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait CommonsTrait
{
	/**
	 * @param Order $order
	 * @param ContainerInterface $container
	 */
	protected function handleInvitationInOrder(Order $order, ContainerInterface $container)
	{
		/**
		 * @var InvitationService $invitationService
		 */
		$invitationService = $container->get(InvitationService::class);

		/**
		 * @var EntityManagerInterface $entityManager
		 */
		$entityManager = $container->get(EntityManagerInterface::class);

		if (($invitation = $order->getInvitation()) && $invitation->getStatus()->is(Status::PENDING)){
			$invitationService->accept($invitation->getId(), $order->getAssignee()->getId());
			$order->setInvitation(null);
			$entityManager->flush();
		}
	}

	/**
	 * @param Order $order
	 * @param AdditionalDocumentPersistable $persistable
	 * @param ContainerInterface $container
	 * @return AdditionalDocument
	 */
	protected function createAdditionalDocumentInMemory(
		Order $order,
		AdditionalDocumentPersistable $persistable,
		ContainerInterface $container
	)
	{
		/**
		 * @var EnvironmentInterface $environment
		 */
		$environment = $container->get(EnvironmentInterface::class);

		/**
		 * @var EntityManagerInterface $entityManager
		 */
		$entityManager = $container->get(EntityManagerInterface::class);

		$additionalDocument = new AdditionalDocument();
		$additionalDocument->setOrder($order);

		if ($createdAt = $environment->getLogCreatedAt()){
			$additionalDocument->setCreatedAt($createdAt);
		} else {
			$additionalDocument->setCreatedAt(new DateTime());
		}

		$additionalDocument->setLabel($persistable->getLabel());

		if ($persistable->getType()){

			/**
			 * @var AdditionalDocumentType $type
			 */
			$type = $entityManager->getReference(AdditionalDocumentType::class, $persistable->getType());

			$additionalDocument->setType($type);
		}

		/**
		 * @var Document $document
		 */
		$document = $entityManager->getReference(Document::class, $persistable->getDocument()->getId());

		$additionalDocument->setDocument($document);

		return $additionalDocument;
	}

	/**
	 * @param Order $order
	 * @param ProcessStatus $newProcessStatus
	 * @param ContainerInterface $container
	 * @return ProcessStatus[]
	 */
	protected function handleProcessStatusTransitionInMemory(Order $order, ProcessStatus $newProcessStatus, ContainerInterface $container)
	{
		$oldProcessStatus = $order->getProcessStatus();

		/**
		 * @var EnvironmentInterface $environment
		 */
		$environment = $container->get(EnvironmentInterface::class);

		$occurredAt = $environment->getLogCreatedAt() ?? new DateTime();

		if ($newProcessStatus->is(ProcessStatus::ACCEPTED)){
			$order->setAcceptedAt($occurredAt);
		}

		if ($newProcessStatus->is(ProcessStatus::REVISION_PENDING)){
			$order->setRevisionReceivedAt($occurredAt);
		}

		if ($newProcessStatus->is(ProcessStatus::COMPLETED)){
			$order->setCompletedAt($occurredAt);
		}

		$order->setProcessStatus($newProcessStatus);

		return [$oldProcessStatus, $newProcessStatus];
	}
}