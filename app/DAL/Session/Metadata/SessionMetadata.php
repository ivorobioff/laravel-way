<?php
namespace RealEstate\DAL\Session\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('sessions');

		$this->defineId($builder);

        $builder->createField('token', 'string')
            ->unique()
            ->length(100)
            ->build();

        $builder
            ->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id', true, false, 'CASCADE')
            ->build();

        $builder->createField('expireAt', 'datetime')->build();

        $builder->createField('createdAt', 'datetime')->build();
    }
}