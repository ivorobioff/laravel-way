<?php
namespace RealEstate\Core\Appraisal\Services;

use Restate\Libraries\Validation\Rules\Email;
use RealEstate\Core\Appraisal\Criteria\AdditionalDocumentSorterResolver;
use RealEstate\Core\Appraisal\Emails\AppraiserAdditionalDocumentEmail;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Options\FetchAdditionalDocumentsOptions;
use RealEstate\Core\Shared\Exceptions\InvalidEmailException;
use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification;
use RealEstate\Core\Appraisal\Persistables\AdditionalDocumentPersistable;
use RealEstate\Core\Appraisal\Validation\AdditionalDocumentValidator;
use RealEstate\Core\Customer\Entities\AdditionalDocumentType;
use RealEstate\Core\Support\Criteria\Sorting\Sorter;
use RealEstate\Core\Support\Letter\EmailerInterface;
use RealEstate\Core\Support\Letter\LetterPreferenceInterface;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentService extends AbstractService
{
	use CommonsTrait;

	/**
	 * @param int $orderId
	 * @param AdditionalDocumentPersistable $persistable
	 * @return AdditionalDocument
	 */
	public function create($orderId,  AdditionalDocumentPersistable $persistable)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->getReference(Order::class, $orderId);

		(new AdditionalDocumentValidator($this->container, $order->getCustomer()))->validate($persistable);

		$additionalDocument = $this->createAdditionalDocumentInMemory($order, $persistable, $this->container);

		$this->entityManager->persist($additionalDocument);
		$this->entityManager->flush();

		$this->notify(new CreateAdditionalDocumentNotification($additionalDocument));

		return $additionalDocument;
	}

	/**
	 * @param int $id
	 * @return AdditionalDocument
	 */
	public function get($id)
	{
		return $this->entityManager->find(AdditionalDocument::class, $id);
	}

	/**
	 * @param int $orderId
	 * @param FetchAdditionalDocumentsOptions $options
	 * @return AdditionalDocument[]
	 */
	public function getAll($orderId, FetchAdditionalDocumentsOptions $options = null)
	{
		if ($options === null){
			$options = new FetchAdditionalDocumentsOptions();
		}

		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select('d')
			->from(AdditionalDocument::class, 'd')
			->where($builder->expr()->eq('d.order', $orderId));

		(new Sorter())->apply($builder, $options->getSortables(), new AdditionalDocumentSorterResolver());

		return $builder->getQuery()->getResult();
	}

	/**
	 * @param int $orderId
	 * @return AdditionalDocumentType[]
	 */
	public function getTypes($orderId)
	{
		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		return $this->entityManager
			->getRepository(AdditionalDocumentType::class)
			->findBy(['customer' => $order->getCustomer()->getId()]);
	}

	/**
	 * @param int $orderId
	 * @param int $documentId
	 * @return bool
	 */
	public function hasWithDocument($orderId, $documentId)
	{
		return $this->entityManager
			->getRepository(AdditionalDocument::class)
			->exists(['order' => $orderId, 'document' => $documentId]);
	}

	/**
	 * @param int $documentId
	 * @param string $recipient
	 */
	public function emailOnAppraiserBehalf($documentId, $recipient)
	{
		if ($error = (new Email())->check($recipient)){
			throw new InvalidEmailException($error->getMessage());
		}

		/**
		 * @var AdditionalDocument $additionalDocument
		 */
		$additionalDocument = $this->entityManager->find(AdditionalDocument::class, $documentId);;

		/**
		 * @var EmailerInterface $emailer
		 */
		$emailer = $this->container->get(EmailerInterface::class);

		/**
		 * @var LetterPreferenceInterface $preference
		 */
		$preference = $this->container->get(LetterPreferenceInterface::class);

		$email = new AppraiserAdditionalDocumentEmail($additionalDocument);

		$appraiser = $additionalDocument->getOrder()->getAssignee();

		$email->setSender($preference->getNoReply(), $appraiser->getDisplayName());
		$email->addRecipient($recipient);

		$emailer->send($email);
	}

	/**
	 * @param int $id
	 */
	public function delete($id)
	{
		/**
		 * @var AdditionalDocument $document
		 */
		$document = $this->entityManager->find(AdditionalDocument::class, $id);

		$this->notify(new DeleteAdditionalDocumentNotification($document));

		$this->removeFromMemory($document);
		$this->entityManager->flush();
	}

	/**
	 * @param int $orderId
	 */
	public function deleteAll($orderId)
	{
		/**
		 * @var AdditionalDocument[] $documents
		 */
		$documents = $this->entityManager
			->getRepository(AdditionalDocument::class)
			->findBy(['order' => $orderId]);

		foreach ($documents as $document){
			$this->removeFromMemory($document);
		}

		$this->entityManager->flush();
	}



	/**
	 * @param AdditionalDocument $document
	 */
	private function removeFromMemory(AdditionalDocument $document)
	{
		$document->setDocument(null);

		$this->entityManager->remove($document);
	}
}