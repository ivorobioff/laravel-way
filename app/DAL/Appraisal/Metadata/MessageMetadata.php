<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Message;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;
use RealEstate\Core\Customer\Entities\Message as CustomerMessage;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('messages')
			->setSingleTableInheritance()
			->setDiscriminatorColumn('type', 'string', 50)
			->addDiscriminatorMapClass('normal', Message::class)
			->addDiscriminatorMapClass('customer', CustomerMessage::class);

		$this->defineId($builder);

		$builder
			->createField('content', 'text')
			->build();

		$builder
			->createField('createdAt', 'datetime')
			->build();

		$builder
			->createManyToOne('sender', User::class)
			->build();

		$builder
			->createManyToOne('order', Order::class)
			->build();

		$builder
			->createManyToMany('readers', User::class)
			->setJoinTable('message_readers')
			->build();
	}
}