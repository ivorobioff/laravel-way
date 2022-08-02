<?php
namespace RealEstate\DAL\Payment\Types;
use RealEstate\Core\Payment\Enums\AccountType;
use RealEstate\DAL\Support\EnumType;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AccountTypeType extends EnumType
{
    /**
     * @return string
     */
    protected function getEnumClass()
    {
        return AccountType::class;
    }
}