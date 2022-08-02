<?php
namespace RealEstate\DAL\Location\Support;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ErrorType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return Error::class;
    }
}