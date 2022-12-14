<?php
namespace RealEstate\Core\Asc\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param string $value
     */
	public function whereLicenseNumberSimilar(QueryBuilder $builder, $value)
    {
		$builder->andWhere($builder->expr()->like('a.licenseNumber', ':licenseNumber'))
			->setParameter('licenseNumber', '%' . addcslashes($value, '%_') . '%');
    }

	/**
	 * @param QueryBuilder $builder
	 * @param string $value
	 */
	public function whereLicenseStateEqual(QueryBuilder $builder, $value)
	{
		$builder->andWhere($builder->expr()->eq('a.licenseState', ':licenseState'))
			->setParameter('licenseState', $value);
	}

	/**
	 * @param QueryBuilder $builder
	 * @param string $value
	 */
	public function whereIsTiedEqual(QueryBuilder $builder, $value)
	{
		if ($value){
			$builder->andWhere($builder->expr()->isNotNull('a.appraiser'));
		} else {
			$builder->andWhere($builder->expr()->isNull('a.appraiser'));
		}
	}
}