<?php
namespace RealEstate\Core\Appraisal\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageFilterResolver extends AbstractResolver
{
	/**
	 * @param QueryBuilder $builder
	 * @param int $reader
	 */
	public function whereReadersContain(QueryBuilder $builder, $reader)
	{
		$builder
			->andWhere($builder->expr()->isMemberOf(':reader', 'm.readers'))
			->setParameter('reader', $reader);
	}

	/**
	 * @param QueryBuilder $builder
	 * @param int $reader
	 */
	public function whereReadersNotContain(QueryBuilder $builder, $reader)
	{
		$builder
			->andWhere(':reader NOT MEMBER OF m.readers')
			->setParameter('reader', $reader);
	}
}