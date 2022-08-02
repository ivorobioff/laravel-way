<?php
namespace RealEstate\Core\Appraisal\Enums\Property;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Occupancy extends Enum
{
	const OWNER = 'owner';
	const TENANT = 'tenant';
	const NEW_CONSTRUCTION = 'new-construction';
	const UNKNOWN = 'unknown';
}