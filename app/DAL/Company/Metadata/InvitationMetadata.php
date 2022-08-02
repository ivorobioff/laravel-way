<?php
namespace RealEstate\DAL\Company\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Asc\Entities\AscAppraiser;
use RealEstate\Core\Company\Entities\Branch;
use RealEstate\DAL\Invitation\Types\RequirementsType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

class InvitationMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('company_invitations');

        $this->defineId($builder);

        $builder
            ->createField('email', 'string')
            ->length(self::EMAIL_LENGTH)
            ->build();

        $builder
            ->createField('phone', 'string')
            ->length(self::PHONE_LENGTH)
            ->build();

        $builder
            ->createManyToOne('ascAppraiser', AscAppraiser::class)
            ->build();

        $builder
            ->createManyToOne('branch', Branch::class)
            ->build();

        $builder
            ->createField('requirements', RequirementsType::class)
            ->build();
    }
}
