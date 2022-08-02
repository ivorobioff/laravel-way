<?php
namespace RealEstate\Core\Invitation\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Requirement extends Enum
{
	const ACH = 'ach';
	const RESUME = 'resume';
	const SAMPLE_REPORTS = 'sample-reports';
}