<?php
namespace RealEstate\Core\Payment\Enums;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AccountType extends Enum
{
    const CHECKING = 'checking';
    const SAVINGS = 'savings';
    const BUSINESS_CHECKING = 'business-checking';
}