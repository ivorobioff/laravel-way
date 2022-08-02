<?php
namespace RealEstate\Core\Appraiser\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CommercialExpertise extends Enum
{
	const WINERY = 'winery';
	const HOSPITALITY = 'hospitality';
	const SELF_STORAGE = 'self-storage';
	const AGRICULTURAL = 'agricultural';
	const INDUSTRIAL = 'industrial';
	const LAND = 'land';
	const MULTI_FAMILY = 'multi-family';
	const OFFICE = 'office';
	const RETAIL = 'retail';
	const OTHER = 'other';
}