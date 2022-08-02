<?php
namespace RealEstate\Core\Customer\Enums;

use Restate\Libraries\Enum\Enum;
use RealEstate\Core\Document\Enums\Format as SourceFormat;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExtraFormat extends Enum
{
	const ACI = SourceFormat::ACI;
	const ZAP = SourceFormat::ZAP;
	const ENV = SourceFormat::ENV;
	const ZOO = SourceFormat::ZOO;
}