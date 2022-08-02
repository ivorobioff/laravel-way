<?php
namespace RealEstate\DAL\Invitation\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\DAL\Invitation\Types\RequirementsType;
use RealEstate\DAL\Invitation\Types\StatusType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;
use RealEstate\Core\Asc\Entities\AscAppraiser;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('invitations');

		$this->defineId($builder);

		$builder
			->createField('reference', 'string')
			->build();

		$builder
			->createManyToOne('customer', Customer::class)
			->build();

		$builder
			->createManyToOne('appraiser', Appraiser::class)
			->build();

		$builder
			->createManyToOne('ascAppraiser', AscAppraiser::class)
			->build();

		$builder
			->createField('status', StatusType::class)
			->build();

		$builder
			->createField('createdAt', 'datetime')
			->build();

		$builder->createField('requirements', RequirementsType::class)
			->build();

	}
}