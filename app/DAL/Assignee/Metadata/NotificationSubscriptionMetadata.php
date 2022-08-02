<?php
namespace RealEstate\DAL\Assignee\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class NotificationSubscriptionMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('notification_subscriptions');

		$this->defineId($builder);

		$builder
			->createManyToOne('assignee', User::class)
			->build();

		$builder
			->createManyToOne('customer', Customer::class)
			->build();

		$builder
			->createField('email', 'boolean')
			->build();
	}
}