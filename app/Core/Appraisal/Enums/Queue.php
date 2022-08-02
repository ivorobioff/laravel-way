<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Queue extends Enum
{
	const FRESH = 'new';
	const ACCEPTED = 'accepted';
	const INSPECTED = 'inspected';
	const SCHEDULED = 'scheduled';
	const ON_HOLD = 'on-hold';
	const DUE = 'due';
	const LATE = 'late';
	const READY_FOR_REVIEW = 'ready-for-review';
	const COMPLETED = 'completed';
	const REVISION = 'revision';
	const OPEN = 'open';
	const ALL = 'all';
}