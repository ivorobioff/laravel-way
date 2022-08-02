<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ContactType extends Enum
{
	const BORROWER = 'borrower';
	const CO_BORROWER = 'co-borrower';
	const OWNER = 'owner';
	const REALTOR = 'realtor';
	const OTHER = 'other';
}