<?php
namespace RealEstate\Core\JobType\Services;

use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypeService extends AbstractService
{
	/**
	 * @return JobType[]
	 */
	public function getAll()
	{
		return $this->entityManager->getRepository(JobType::class)->findAll();
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function exists($id)
	{
		return $this->entityManager->getRepository(JobType::class)->exists(['id' => $id]);
	}

	/**
	 * @param array $ids
	 * @return bool
	 */
	public function existSelected(array $ids)
	{
		return count($ids) === $this->entityManager->getRepository(JobType::class)
			->count(['id' => ['in', $ids]]);
	}
}