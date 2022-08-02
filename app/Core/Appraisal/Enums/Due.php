<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Due extends Enum
{
	const TODAY = 'today';
	const TOMORROW = 'tomorrow';
	const NEXT_7_DAYS = 'next-7-days';
}