<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OwnerInterest extends Enum
{
	const AIR_RIGHTS = 'air-rights';
	const FEE_SIMPLE = 'fee-simple';
	const LEASED_FEE = 'leased-fee';
	const DUPLEX = 'duplex';
	const LEASEHOLD = 'leasehold';
	const PARTIAL_INTEREST = 'partial-interest';
}