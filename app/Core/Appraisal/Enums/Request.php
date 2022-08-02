<?php
namespace RealEstate\Core\Appraisal\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Request extends Enum
{
	const FEE_INCREASE = 'fee-increase';
	const DUE_DATE_EXTENSION = 'due-date-extension';
	const FEE_INCREASE_AND_DUE_DATE_EXTENSION = 'fee-increase-and-due-date-extension';
	const OTHER = 'other';
}