<?php
namespace RealEstate\DAL\User\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Back\Entities\Admin;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\User\Entities\System;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;
use RealEstate\DAL\User\Types\StatusType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('users')
            ->setSingleTableInheritance()
            ->setDiscriminatorColumn('type', 'string', 20)
            ->addDiscriminatorMapClass('system', System::class)
            ->addDiscriminatorMapClass('admin', Admin::class)
            ->addDiscriminatorMapClass('amc', Amc::class)
            ->addDiscriminatorMapClass('appraiser', Appraiser::class)
			->addDiscriminatorMapClass('customer', Customer::class)
            ->addDiscriminatorMapClass('manager', Manager::class);

		$this->defineId($builder);

        $builder
			->createField('username', 'string')
			->build();

        $builder->createField('password', 'string')
            ->build();

        $builder
            ->createField('email', 'string')
            ->length(static::EMAIL_LENGTH)
            ->nullable(true)
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->nullable(true)
            ->build();


        $builder
            ->createField('updatedAt', 'datetime')
            ->nullable(true)
            ->build();

        $builder
            ->createField('status', StatusType::class)
            ->build();
    }
}