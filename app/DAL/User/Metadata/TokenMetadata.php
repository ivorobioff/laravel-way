<?php
namespace RealEstate\DAL\User\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;
use RealEstate\DAL\User\Types\IntentType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class TokenMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('tokens');

		$this->defineId($builder);

		$builder
			->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id', true, false, 'CASCADE')
			->build();

		$builder
			->createField('value', 'string')
			->unique(true)
			->length(100)
			->build();

		$builder
			->createField('intent', IntentType::class)
			->build();

		$builder
			->createField('createdAt', 'datetime')
			->build();

		$builder
			->createField('expiresAt', 'datetime')
			->build();
	}
}