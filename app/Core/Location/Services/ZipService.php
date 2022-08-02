<?php
namespace RealEstate\Core\Location\Services;
use RealEstate\Core\Location\Entities\Zip;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ZipService extends AbstractService
{
    /**
     * @param $state
     * @return array
     */
    public function getAllInState($state)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $data = $builder
            ->from(Zip::class, 'z')
            ->select('z.code')
            ->distinct(true)
            ->leftJoin('z.county', 'c')
            ->where($builder->expr()->eq('c.state', ':state'))
            ->setParameter('state', $state)
            ->getQuery()
            ->getArrayResult();

        return array_map(function($value){ return $value['code']; },$data);
    }

    /**
     * @param array $codes
     * @param string $state
     * @return bool
     */
    public function existSelectedInState(array $codes, $state)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $total = (int) $builder
            ->from(Zip::class, 'z')
            ->select($builder->expr()->countDistinct('z'))
            ->leftJoin('z.county', 'c')
            ->where($builder->expr()->eq('c.state', ':state'))
            ->andWhere($builder->expr()->in('z.code', ':codes'))
            ->setParameter('state', $state)
            ->setParameter('codes', $codes)
            ->getQuery()
            ->getSingleScalarResult();

        return count($codes) === $total;
    }
}