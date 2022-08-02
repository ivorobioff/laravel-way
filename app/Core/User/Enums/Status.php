<?php
namespace RealEstate\Core\User\Enums;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Status extends Enum
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const DECLINED = 'declined';
    const DISABLED = 'disabled';
}