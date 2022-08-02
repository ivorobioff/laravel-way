<?php
namespace RealEstate\Core\Payment\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Status extends Enum
{
	const APPROVED = 'approved';
	const DECLINED = 'declined';
	const ERROR = 'error';
	const PENDING = 'pending';
}