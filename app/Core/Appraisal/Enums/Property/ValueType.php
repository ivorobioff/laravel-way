<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ValueType extends Enum
{
	const FAIR_MARKET_RENTAL = 'fair-market-rental';
	const MARKET = 'market';
	const INSURABLE = 'insurable';
	const LIQUIDATION = 'liquidation';
}