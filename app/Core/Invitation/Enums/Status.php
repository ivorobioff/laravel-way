<?php
namespace RealEstate\Core\Invitation\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Status extends Enum
{
	const PENDING = 'pending';
	const ACCEPTED = 'accepted';
	const DECLINED = 'declined';
}