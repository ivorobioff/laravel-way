<?php
namespace RealEstate\DAL\Payment\Types;
use RealEstate\Core\Payment\Enums\Status;
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