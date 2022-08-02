<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeclineReason extends Enum
{
	const TOO_BUSY = 'too-busy';
	const OUT_OF_COVERAGE_AREA = 'out-of-coverage-area';
	const OTHER = 'other';
}