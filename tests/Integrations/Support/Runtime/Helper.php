<?php
namespace RealEstate\Tests\Integrations\Support\Runtime;

use Doctrine\ORM\EntityManagerInterface;
use RealEstate\Core\Location\Entities\County;
use RuntimeException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Helper
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param string $name
	 * @param string $state
	 * @return int
	 */
	public function county($name, $state)
	{
		/**
		 * @var County $county
		 */
		$county = $this->entityManager->getRepository(County::class)->findOneBy(['title' => $name, 'state' => $state]);

		if (!$county){
			throw new RuntimeException('Unable to find the "'.$name.'" county.');
		}

		return $county->getId();
	}
}