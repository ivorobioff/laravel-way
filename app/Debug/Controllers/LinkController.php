<?php
namespace RealEstate\Debug\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Debug\Processors\LinkProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LinkController extends BaseController
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function initialize(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function store(LinkProcessor $processor)
	{
		/**
		 * @var Customer $customer
		 */
		$customer = $this->entityManager->find(Customer::class, $processor->getCustomer());

		/**
		 * @var Appraiser $appraiser
		 */
		$appraiser = $this->entityManager->find(Appraiser::class, $processor->getAppraiser());

		$customer->addAppraiser($appraiser);

		$this->entityManager->flush();
	}
}