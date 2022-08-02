<?php
namespace RealEstate\Core\Appraisal\Services;

use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Reconsideration;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Appraisal\Persistables\ReconsiderationPersistable;
use RealEstate\Core\Appraisal\Validation\ReconsiderationValidator;
use DateTime;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationService extends AbstractService
{
	use CommonsTrait;

    /**
     * @param int $id
     * @return Reconsideration
     */
    public function get($id)
    {
        return $this->entityManager->find(Reconsideration::class, $id);
    }

	/**
	 * @param $orderId
	 * @param ReconsiderationPersistable $persistable
	 * @return Reconsideration
	 */
	public function create($orderId, ReconsiderationPersistable $persistable)
	{
        /**
         * @var Order $order
         */
        $order = $this->entityManager->find(Order::class, $orderId);

		(new ReconsiderationValidator($this->container, $order->getCustomer()))->validate($persistable);


		$reconsideration = new Reconsideration();

		$reconsideration->setComment($persistable->getComment());

        if ($document = $persistable->getDocument()){
            $document = $this->createAdditionalDocumentInMemory($order, $document, $this->container);
            $this->entityManager->persist($document);
            $this->entityManager->flush();
            $reconsideration->setDocument($document);
        }

		if ($createdAt = $this->environment->getLogCreatedAt()){
			$reconsideration->setCreatedAt($createdAt);
		} else {
			$reconsideration->setCreatedAt(new DateTime());
		}

		$comparables = $persistable->getComparables();

        if ($comparables !== null){
            $reconsideration->setComparables($comparables);
        }

        $reconsideration->setOrder($order);

		$this->entityManager->persist($reconsideration);

		list($oldProcessStatus, $newProcessStatus) =  $this->handleProcessStatusTransitionInMemory(
			$order, new ProcessStatus(ProcessStatus::REVISION_PENDING), $this->container);

		$this->entityManager->flush();

		$notification = new ReconsiderationRequestNotification($order, $reconsideration);

		$notification->setUpdateProcessStatusNotification(
			new UpdateProcessStatusNotification($order,  $oldProcessStatus, $newProcessStatus));

		$this->notify($notification);

		return $reconsideration;
	}

	/**
	 * @param int $orderId
	 * @return Reconsideration[]
	 */
	public function getAll($orderId)
	{
		return $this->entityManager
			->getRepository(Reconsideration::class)
			->findBy(['order' => $orderId]);
	}

	/**
	 * @param int $orderId
	 */
	public function deleteAll($orderId)
	{
		$this->entityManager->getRepository(Reconsideration::class)->delete(['order' => $orderId]);
	}
}