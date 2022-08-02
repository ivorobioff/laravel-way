<?php
namespace RealEstate\DAL\Appraiser\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class EoExMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        for ($i = 1; $i <= 7; $i ++) {
            $builder
                ->createField('question'.$i, 'boolean')
                ->build();

            $builder
                ->createField('question'.$i.'Explanation', 'string')
                ->nullable(true)
                ->build();
        }

        $builder
            ->createManyToOne('question1Document', Document::class)
            ->build();
    }
}