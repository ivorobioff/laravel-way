<?php
namespace RealEstate\DAL\User\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;
use RealEstate\DAL\User\Types\PlatformType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeviceMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('devices');
		$this->defineId($builder);
		
		$builder
			->createField('token', 'string')
			->build();

		$builder
			->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id', true, false, 'CASCADE')
			->build();
		
		$builder
			->createField('platform', PlatformType::class)
			->build();
	}
}