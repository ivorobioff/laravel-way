<?php
namespace RealEstate\Core\Asc\Enums;

use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Certification extends Enum
{
    const LICENSED = 'licensed';
	const CERTIFIED_RESIDENTIAL = 'certified-residential';
    const CERTIFIED_GENERAL = 'certified-general';
	const TRANSITIONAL_LICENSE = 'transitional-license';
}