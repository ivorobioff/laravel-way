<?php
namespace RealEstate\Core\Asc\Services;

use RealEstate\Core\Appraiser\Persistables\LicensePersistable;
use RealEstate\Core\Asc\Criteria\FilterResolver;
use RealEstate\Core\Asc\Entities\AscAppraiser;
use RealEstate\Core\Asc\Enums\Certifications;
use RealEstate\Core\Asc\Interfaces\ImporterInterface;
use RealEstate\Core\Asc\Persistables\AppraiserPersistable;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Shared\Options\PaginationOptions;
use RealEstate\Core\Support\Criteria\Criteria;
use RealEstate\Core\Support\Criteria\Filter;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AscService extends AbstractService
{
	/**
	 * @param int $id
	 * @return AscAppraiser
	 */
	public function get($id)
	{
		return $this->entityManager->find(AscAppraiser::class, $id);
	}

    /**
     * @param Criteria[] $criteria
	 * @param PaginationOptions $options
     * @return AscAppraiser[]
     */
    public function getAllByCriteria(array $criteria, PaginationOptions $options = null)
    {
		if ($options === null){
			$options = new PaginationOptions();
		}

        $builder = $this->entityManager->createQueryBuilder();

        $builder->select('a')->from(AscAppraiser::class, 'a');

        (new Filter())->apply($builder, $criteria, new FilterResolver());
		
		return (new Paginator())->apply($builder, $options);
	}

	/**
	 * @param array $criteria
	 * @return int
	 */
	public function getTotalByCriteria(array $criteria)
	{
		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select($builder->expr()->countDistinct('a'))
			->from(AscAppraiser::class, 'a');

		(new Filter())->apply($builder, $criteria, new FilterResolver());

		return (int) $builder->getQuery()->getSingleScalarResult();
	}

	/**
	 * @var string $licenseNumber
	 * @return AscAppraiser
	 */
	public function getByLicenseNumber($licenseNumber)
	{
		return $this->entityManager
			->getRepository(AscAppraiser::class)
			->findOneBy(['licenseNumber' => $licenseNumber]);
	}

    /**
     * @param string $licenseNumber
     * @param string $state
     * @return bool
     */
    public function existsWithLicenseNumberInState($licenseNumber, $state)
    {
        return $this->entityManager
			->getRepository(AscAppraiser::class)
			->exists(['licenseNumber' => $licenseNumber, 'licenseState' => $state]);
    }

	/**
	 * @param int $id
	 * @return bool
	 */
	public function exists($id)
	{
		return $this->entityManager->getRepository(AscAppraiser::class)->exists(['id' => $id]);
	}

	/**
	 * @param LicensePersistable $persistable
	 * @return AscAppraiser
	 */
	public function generate(LicensePersistable $persistable)
	{
		$appraiser = new AscAppraiser();

		$appraiser->setFirstName('John');
		$appraiser->setLastName('Smith');
		$appraiser->setPhone('(000) 000-0000');

		$appraiser->setAddress('1st Address');
		$appraiser->setCity('San Francisco');

		/**
		 * @var State $state
		 */
		$state = $this->entityManager->getReference(State::class, 'CA');

		$appraiser->setState($state);

		$appraiser->setZip('94132');

		$appraiser->setCertifications($persistable->getCertifications());
		$appraiser->setCompanyName('Fake Inc.');
		$appraiser->setLicenseExpiresAt($persistable->getExpiresAt());

		/**
		 * @var State $state
		 */
		$state = $this->entityManager->getReference(State::class, $persistable->getState());

		$appraiser->setLicenseState($state);

		$appraiser->setLicenseNumber(uniqid('AAA'));

		$this->entityManager->persist($appraiser);
		$this->entityManager->flush();

		return $appraiser;
	}

	public function import()
	{
		/**
		 * @var ImporterInterface $importer
		 */
		$importer = $this->container->get(ImporterInterface::class);

		$c = 0;

		$cache = [];

		foreach ($importer->import() as $persistable){

			$identifier = $persistable->getLicenseState().'-'.$persistable->getLicenseNumber();

			$appraiser = array_take($cache, $identifier);

			if ($appraiser === null){
				$appraiser = $this->entityManager->getRepository(AscAppraiser::class)
					->findOneBy([
						'licenseNumber' => $persistable->getLicenseNumber(),
						'licenseState' => $persistable->getLicenseState()
					]);
			}

			if ($appraiser === null){
				$appraiser = new AscAppraiser();
			}

			$this->exchange($persistable, $appraiser);

			if ($appraiser->getId() === null){
				$this->entityManager->persist($appraiser);
				$cache[$identifier] = $appraiser;
			}

			if ($c == 100){
				$this->entityManager->flush();
				$this->entityManager->clear();
				$c = 0;
				$cache = [];
			}

			$c++;
		}

		$this->entityManager->flush();
	}

	/**
	 * @param AppraiserPersistable $persistable
	 * @param AscAppraiser $appraiser
	 */
	private function exchange(AppraiserPersistable $persistable, AscAppraiser $appraiser)
	{
		$appraiser->setPhone($persistable->getPhone());
		$appraiser->setFirstName($persistable->getFirstName());
		$appraiser->setLastName($persistable->getLastName());
		$appraiser->setCity($persistable->getCity());
		$appraiser->setZip($persistable->getZip());
		$appraiser->setAddress($persistable->getAddress());
		$appraiser->setCompanyName($persistable->getCompanyName());

		if ($appraiser->getCertifications() !== null){
			$certifications = new Certifications($appraiser->getCertifications());
		} else {
			$certifications = new Certifications();
		}

		$certification = $persistable->getCertifications()[0];

		if (!$certifications->has($certification)){
			$certifications->push($certification);
			$appraiser->setCertifications($certifications);
		}

		if ($persistable->getLicenseExpiresAt()){
			$appraiser->setLicenseExpiresAt($persistable->getLicenseExpiresAt());
		}

		$appraiser->setLicenseNumber($persistable->getLicenseNumber());

		if ($persistable->getState()){
			/**
			 * @var State $state
			 */
			$state = $this->entityManager->getReference(State::class, $persistable->getState());
			$appraiser->setState($state);
		}

		/**
		 * @var State $licenseState
		 */
		$licenseState = $this->entityManager->getReference(State::class, $persistable->getLicenseState());
		$appraiser->setLicenseState($licenseState);
	}
}