<?php
namespace RealEstate\Core\Payment\Enums;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Means extends Enum
{
    const BANK_ACCOUNT = 'bank-account';
    const CREDIT_CARD = 'credit-card';
}