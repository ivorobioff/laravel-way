<?php
namespace RealEstate\Core\Appraisal\Services;

use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Appraisal\Entities\Bid;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Exceptions\OperationNotPermittedWithCurrentProcessStatusException;
use RealEstate\Core\Appraisal\Notifications\SubmitBidNotification;
use RealEstate\Core\Appraisal\Options\CreateBidOptions;
use RealEstate\Core\Appraisal\Options\UpdateBidOptions;
use RealEstate\Core\Appraisal\Persistables\BidPersistable;
use RealEstate\Core\Appraisal\Validation\BidValidator;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidService extends AbstractService
{
	use CommonsTrait;

	/**
	 * @param int $orderId
	 * @return Bid
	 */
	public function get($orderId)
	{
		return $this->entityManager->getRepository(Bid::class)->findOneBy(['order' => $orderId]);
	}

	/**
	 * @param int $orderId
	 * @param BidPersistable $persistable
	 * @param CreateBidOptions $options
	 * @return Bid
	 */
	public function create($orderId, BidPersistable $persistable, CreateBidOptions $options = null)
	{
		if ($options === null){
			$options = new CreateBidOptions();
		}

		/**
		 * @var Order $order
		 */
		$order = $this->entityManager->find(Order::class, $orderId);

		if (!$order->getProcessStatus()->is(ProcessStatus::REQUEST_FOR_BID)){
			throw  new OperationNotPermittedWithCurrentProcessStatusException();
		}

		if ($order->getBid()){
			throw new PresentableException('The bid has been already created for this order.');
		}

		(new BidValidator($this->environment))
			->requireEstimatedCompletionDate($options->isEstimatedCompletionDateRequired())
			->validate($persistable);


		$this->handleInvitationInOrder($order, $this->container);

		$bid = new Bid();

		$bid->setOrder($order);

		$this->transfer($persistable, $bid);

		$this->entityManager->persist($bid);

		$this->entityManager->flush();

		$this->notify(new SubmitBidNotification($order));

		return $bid;
	}

	/**
	 * @param int $orderId
	 * @param BidPersistable $persistable
	 * @param UpdateBidOptions $options
	 */
	public function update($orderId, BidPersistable $persistable, UpdateBidOptions $options = null)
	{
		if ($options === null){
			$options = new UpdateBidOptions();
		}

		(new BidValidator($this->environment))
			->requireEstimatedCompletionDate($options->isEstimatedCompletionDateRequired())
			->setForcedProperties($options->getPropertiesScheduledToClear())
			->validate($persistable, true);

		/**
		 * @var Bid $bid
		 */
		$bid = $this->entityManager->getRepository(Bid::class)->findOneBy(['order' => $orderId]);

		$this->transfer($persistable, $bid, ['nullable' => $options->getPropertiesScheduledToClear()]);

		$this->entityManager->flush();
	}
}