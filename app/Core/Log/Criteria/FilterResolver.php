<?php
namespace RealEstate\Core\Log\Criteria;

use Doctrine\ORM\QueryBuilder;
use RealEstate\Core\Support\Criteria\AbstractResolver;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FilterResolver extends AbstractResolver
{
	/**
	 * @param QueryBuilder $builder
	 * @param User $user
	 */
	public function whereInitiatorNotEqual(QueryBuilder $builder, User $user)
	{
		$builder->andWhere($builder->expr()->neq('l.user', $user->getId()));
	}
}