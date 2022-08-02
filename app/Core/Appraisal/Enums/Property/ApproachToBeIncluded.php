<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ApproachToBeIncluded extends Enum
{
	const INCOME = 'income';
	const SALES = 'sales';
	const COST = 'cost';
}