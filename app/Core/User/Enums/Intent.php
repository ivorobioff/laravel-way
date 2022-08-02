<?php
namespace RealEstate\Core\User\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Intent extends Enum
{
	const RESET_PASSWORD = 'reset-password';
	const AUTO_LOGIN = 'auto-login';
}