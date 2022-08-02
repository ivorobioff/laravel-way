<?php
namespace RealEstate\Core\Customer\Enums;

use Restate\Libraries\Enum\Enum;
use RealEstate\Core\Document\Enums\Format as SourceFormat;
/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Format extends Enum
{
	const PDF = SourceFormat::PDF;
	const XML = SourceFormat::XML;
	const ENV = SourceFormat::ENV;
}