<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ProcessStatus extends Enum
{
	const FRESH = 'new';
	const REQUEST_FOR_BID = 'request-for-bid';
	const ACCEPTED = 'accepted';
	const INSPECTION_SCHEDULED = 'inspection-scheduled';
	const INSPECTION_COMPLETED = 'inspection-completed';
	const READY_FOR_REVIEW = 'ready-for-review';
	const LATE = 'late';
	const ON_HOLD = 'on-hold';
	const REVISION_PENDING = 'revision-pending';
	const REVISION_IN_REVIEW = 'revision-in-review';
	const COMPLETED = 'completed';
	const REVIEWED = 'reviewed';

	/**
	 * @return array
	 */
	public static function dueToArray()
	{
		return [
			static::ACCEPTED,
			static::INSPECTION_SCHEDULED,
			static::INSPECTION_COMPLETED
		];
	}

	/**
	 * @return static[]
	 */
	public static function dueToObjects()
	{
		return array_map(function($status){ return new static($status); }, static::dueToArray());
	}
}