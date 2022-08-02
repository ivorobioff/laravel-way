<?php
namespace RealEstate\DAL\Appraisal\Types;
use RealEstate\Core\Appraisal\Enums\AssetType;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AssetTypeType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return AssetType::class;
    }
}