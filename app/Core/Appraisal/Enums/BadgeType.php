<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BadgeType extends Enum
{
	const FRESH = 'new';
	const REQUEST_FOR_BID = 'request-for-bid';
	const INSPECTION_SCHEDULED = 'inspection-scheduled';
	const DUE = 'due';
}