<?php
namespace RealEstate\Core\Appraisal\Options;

use RealEstate\Core\Shared\Options\UpdateOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateDocumentOptions extends UpdateOptions
{
	use CheckDocumentSupportedFormatsOptionTrait;
}