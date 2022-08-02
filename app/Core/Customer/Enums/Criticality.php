<?php
namespace RealEstate\Core\Customer\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Criticality extends Enum
{
	const DISABLED = 'disabled';
	const WARNING = 'warning';
	const HARDSTOP = 'hardstop';
}