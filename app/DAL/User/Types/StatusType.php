<?php
namespace RealEstate\DAL\User\Types;
use RealEstate\Core\User\Enums\Status;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StatusType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return Status::class;
    }
}