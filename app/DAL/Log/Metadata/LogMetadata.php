<?php
namespace RealEstate\DAL\Log\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Log\Types\ExtraType;
use RealEstate\DAL\Log\Types\ActionType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LogMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('logs');

		$this->defineId($builder);

		$builder
			->createManyToOne('order', Order::class)
			->build();

		$builder
			->createManyToOne('user', User::class)
			->build();

		$builder
			->createManyToOne('assignee', User::class)
			->build();

        $builder
            ->createManyToOne('customer', Customer::class)
            ->build();

		$builder
			->createField('action', ActionType::class)
			->build();

		$builder
			->createField('extra', ExtraType::class)
			->build();

		$builder
			->createField('createdAt', 'datetime')
			->build();
	}
}