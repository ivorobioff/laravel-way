<?php
namespace RealEstate\Core\Location\Services;

use RealEstate\Core\Location\Entities\County;
use RealEstate\Core\Location\Entities\Zip;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountyService extends AbstractService
{
	/**
	 * @param int $id
	 * @return County
	 */
	public function get($id)
	{
		return $this->entityManager->find(County::class, $id);
	}

	/**
	 * @param int $countyId
	 * @param array $zips
	 * @return bool
	 */
	public function hasZips($countyId, array $zips)
	{
		$total = $this->entityManager
			->getRepository(Zip::class)
			->count(['county' => $countyId, 'code' => ['in', $zips]]);

		return $total == count($zips);
	}

	/**
	 * @param string $state
	 * @param array $selectedCounties
	 * @return County[]
	 */
	public function getAllInState($state, $selectedCounties = [])
	{
		$builder = $this->entityManager->createQueryBuilder();

		$builder
			->select('c')
			->from(County::class, 'c')
			->where($builder->expr()->eq('c.state', ':state'))
			->setParameter('state', $state);

		if ($selectedCounties){
			$builder
				->andWhere($builder->expr()->in('c.id', ':counties'))
				->setParameter('counties', $selectedCounties);
		}

		return $builder->getQuery()->getResult();
	}

	/**
	 * @param array $ids
	 * @param string $state
	 * @return bool
	 */
	public function existSelectedInState(array $ids, $state)
	{
		$total = $this->entityManager->getRepository(County::class)
			->count(['id' => ['in', $ids], 'state' => $state]);

		return count($ids) === $total;
	}
}