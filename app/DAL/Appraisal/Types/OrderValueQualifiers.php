<?php
namespace RealEstate\DAL\Appraisal\Types;
use RealEstate\Core\Appraisal\Enums\ValueQualifiers;
use RealEstate\Core\Appraisal\Enums\ValueQualifier;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrderValueQualifiers extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return ValueQualifier::class;
    }

    /**
     * @return string
     */
    protected function getEnumCollectionClass()
    {
        return ValueQualifiers::class;
    }
}