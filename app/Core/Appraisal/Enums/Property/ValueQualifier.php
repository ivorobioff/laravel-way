<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ValueQualifier extends Enum
{
	const AS_IS = 'as-is';
	const AS_PROPOSED = 'as-proposed';
	const AS_COMPLETE = 'as-complete';
	const AS_STABILIZED = 'as-stabilized';
	const GOING_CONCERN = 'going-concern';
	const LIQUIDATION_FORCED = 'liquidation-forced';
	const LIQUIDATION_ORDERLY = 'liquidation-orderly';
}